<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Track;
use App\Models\Train;
use App\Models\Method;
use App\Models\Passenger;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\Complaint;
use App\Models\OrderSeat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreatedMail;

class OrderController extends Controller
{
    /** Daftar order */
    public function index()
    {
        // gunakan relasi singular 'transaction' (bukan 'transactions')
        $base = Order::with(['ticket.train','ticket.track','seats','transaction'])->latest();
        $orders = Gate::allows('isAdmin') ? $base->get() : $base->where('user_id', Auth::id())->get();

        return view('dashboard.order.index', [
            'orders'     => $orders,
            'complaints' => Complaint::all(),
        ]);
    }

    public function show(Order $order)
    {
        // izinkan admin, atau pemilik order
        if (!Gate::allows('isAdmin') && $order->user_id !== Auth::id()) {
            abort(403);
        }

        // muat relasi yang dibutuhkan
        $order->loadMissing(['user','ticket.train','ticket.track','passengers','transaction']);

        return view('dashboard.order.show', compact('order'));
    }

    /** Form create (wizard 1..4 di Blade) */
    public function create()
    {
        return view('dashboard.order.create', [
            'tracks'  => Track::all(),
            'trains'  => Train::all(),
            'tickets' => Ticket::with(['price','train','track'])->get(),
            'methods' => Method::all(),
        ]);
    }

    /**
     * SLIDE 1: cari tiket berdasarkan asal, tujuan, tanggal
     * GET /orders/search?from_route=..&to_route=..&go_date=YYYY-MM-DD
     * Response: { ok: bool, reason: string, tickets: [{ticket_id,label,remaining,price}], message?: string }
     */
    public function searchTickets(Request $request)
    {
        $request->validate([
            'from_route' => ['required','string'],
            'to_route'   => ['required','string'],
            'go_date'    => ['required','date'],
        ]);

        try {
            $goDate = Carbon::parse($request->go_date)->format('Y-m-d');
        } catch (\Throwable $e) {
            return response()->json(['ok'=>false,'reason'=>'invalid_date','message'=>'Tanggal tidak valid.'], 422);
        }

        // 1) Cek rute ada/tidak
        $routeExists = Track::where('from_route', $request->from_route)
                            ->where('to_route',   $request->to_route)
                            ->exists();

        if (!$routeExists) {
            return response()->json([
                'ok'      => false,
                'reason'  => 'no_route',
                'tickets' => [],
                'message' => 'Rute tidak tersedia untuk kombinasi asal & tujuan tersebut.',
            ]);
        }

        // 2) Ambil tiket untuk rute tsb & FILTER TANGGAL (jadwal per-tanggal).
        $ticketsQ = Ticket::with(['train','track','price'])
            ->whereHas('track', function($q) use ($request){
                $q->where('from_route', $request->from_route)
                  ->where('to_route',   $request->to_route);
            })
            ->whereDate('departure_at', $goDate);

        $ticketsAll = $ticketsQ->get();

        if ($ticketsAll->isEmpty()) {
            // Ada rute, tapi TIDAK ADA tiket utk tanggal tsb
            return response()->json([
                'ok'      => false,
                'reason'  => 'no_ticket_on_date',
                'tickets' => [],
                'message' => 'Tidak ada tiket tersedia pada tanggal tersebut.',
            ]);
        }

        // 3) Hitung sisa kursi khusus utk tanggal yang diminta
        $result = [];
        foreach ($ticketsAll as $t) {
            $capacity = $this->capacityForTrain($t->train);
            $occupied = $this->listOccupiedSeatsNormalized($t->id, $goDate);
            $remaining = max(0, $capacity - count($occupied));

            if ($remaining > 0) {
                $result[] = [
                    'ticket_id' => $t->id,
                    'label'     => sprintf(
                        '%s → %s | %s | %s s.d %s | Rp %s',
                        $t->track->from_route, $t->track->to_route, $t->train->class,
                        optional($t->departure_at)->timezone('Asia/Jakarta')->format('d M Y H:i'),
                        optional($t->arrival_at)->timezone('Asia/Jakarta')->format('d M Y H:i'),
                        $t->price ? number_format($t->price->price,0,',','.') : '-'
                    ),
                    'remaining' => $remaining,
                    'price'     => $t->price->price ?? null,
                ];
            }
        }

        if (empty($result)) {
            // Ada tiket di tanggal itu, tapi penuh
            return response()->json([
                'ok'      => false,
                'reason'  => 'no_seat_left',
                'tickets' => [],
                'message' => 'Kursi untuk tanggal tersebut sudah penuh.',
            ]);
        }

        return response()->json([
            'ok'      => true,
            'reason'  => 'ok',
            'tickets' => $result,
            'message' => null,
        ]);
    }

    /**
     * SLIDE 2: ketersediaan kursi per ticket & tanggal
     * GET /orders/availability?ticket_id=1&go_date=2025-09-03
     * Response: { available, remaining, occupied, max_seats, layout }
     */
    public function availability(Request $request)
    {
        $request->validate([
            'ticket_id' => ['required','integer','exists:tickets,id'],
            'go_date'   => ['required'],
        ]);

        try {
            $goDate = Carbon::parse($request->input('go_date'))->format('Y-m-d');
        } catch (\Throwable $e) {
            return response()->json([
                'available'=>false,'remaining'=>0,'occupied'=>[],
                'message'=>'Tanggal tidak valid.',
            ], 422);
        }

        $ticket   = Ticket::with('train')->findOrFail((int)$request->ticket_id);
        $capacity = $this->capacityForTrain($ticket->train);
        $layout   = $this->resolveLayout($ticket->train);

        // PAKAI daftar occupied yang sudah DINORMALISASI
        $occupied = $this->listOccupiedSeatsNormalized($ticket->id, $goDate);
        $remaining = max(0, $capacity - count($occupied));

        return response()->json([
            'available' => $remaining > 0,
            'remaining' => $remaining,
            'occupied'  => array_values($occupied),
            'max_seats' => $capacity,
            'layout'    => $layout,
        ]);
    }

    /** SLIDE 4: simpan order */
    public function store(Request $request)
    {
        // Validasi dasar
        $data = $request->validate([
            'ticket_id'       => ['required','exists:tickets,id'],
            'go_date'         => ['required','date'],
            'amount'          => ['required','integer','min:1'], // tanpa batas max
            'selected_seats'  => ['required','string'], // CSV "01,02"
            'alamat_lengkap'  => ['required','string','max:255'],
            'nowhatsapp'      => ['required','string','max:50'],
            'method_id'       => ['required','exists:methods,id'],
            'name_account'    => ['required','string','max:100'],
            'from_account'    => ['required','string','max:100'],
        ]);

        $ticket   = Ticket::with(['price','train'])->findOrFail($data['ticket_id']);
        $capacity = $this->capacityForTrain($ticket->train);
        $layout   = $this->resolveLayout($ticket->train);

        // Daftar seat valid dari layout (format kanonik yang dipakai FE)
        $validSeats = $this->seatCodesFromLayout($layout);
        if (empty($validSeats)) {
            for ($i=1; $i<=$capacity; $i++) {
                $validSeats[] = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
            }
        }

        // Parse pilihan user → normalisasi → unik
        $seatsRaw = array_values(array_unique(array_filter(array_map('trim', explode(',', $data['selected_seats'])))));
        $seats    = $this->normalizeSeatArray($seatsRaw, $validSeats);

        // Validasi jumlah & kode kursi
        if (count($seats) !== (int)$data['amount']) {
            return back()->withInput()->with('error', 'Jumlah kursi yang dipilih harus sama dengan jumlah penumpang.');
        }
        if (count($seats) === 0) {
            return back()->withInput()->with('error', 'Kursi tidak valid.');
        }

        // Cek okupansi aktual & kapasitas (pakai normalized)
        $goDate    = Carbon::parse($data['go_date'])->format('Y-m-d');
        $occupied  = $this->listOccupiedSeatsNormalized($ticket->id, $goDate);
        $occupiedS = array_flip($occupied);

        foreach ($seats as $s) {
            if (isset($occupiedS[$s])) {
                return back()->withInput()->with('error', "Kursi $s sudah terisi. Silakan pilih kursi lain.");
            }
        }
        if (count($occupied) + count($seats) > $capacity) {
            return back()->withInput()->with('error', 'Kapasitas kursi sudah penuh untuk jadwal ini.');
        }

        if (!$ticket->price) {
            return back()->withInput()->with('error', 'Harga tiket belum tersedia.');
        }

        try {
            $order = DB::transaction(function () use ($request, $data, $seats, $ticket, $goDate) {
                // Buat order
                $order = Order::create([
                    'user_id'        => Auth::id(),
                    'order_code'     => now()->format('YmdHis') . strtoupper(Str::random(4)),
                    'ticket_id'      => $data['ticket_id'],
                    'go_date'        => $goDate,
                    'amount'         => $data['amount'],
                    'alamat_lengkap' => $data['alamat_lengkap'],
                    'nowhatsapp'     => $data['nowhatsapp'],
                    'selected_seats' => implode(',', $seats),
                ]);

                // kursi
                if (Schema::hasTable('order_seats')) {
                    foreach ($seats as $s) {
                        OrderSeat::updateOrCreate(
                            ['ticket_id' => $data['ticket_id'], 'go_date' => $goDate, 'seat_code' => $s],
                            ['order_id'  => $order->id]
                        );
                    }
                }

                // transaksi
                Transaction::create([
                    'order_id'     => $order->id,
                    'method_id'    => $data['method_id'],
                    'name_account' => $data['name_account'],
                    'from_account' => $data['from_account'],
                    'total'        => $ticket->price->price * (int)$data['amount'],
                    'status'       => false,
                ]);

                // penumpang
                for ($i=1; $i<=(int)$data['amount']; $i++) {
                    $nama = $request->input("nama_penumpang_$i");
                    $umur = $request->input("umur_penumpang_$i");
                    $jk   = $request->input("jenis_penumpang_$i");

                    if (!$nama || $umur===null || $jk===null) {
                        throw new \Exception("Data penumpang ke-$i belum lengkap.");
                    }

                    Passenger::create([
                        'order_id' => $order->id,
                        'name'     => $nama,
                        'umur_penumpang'      => (int)$umur,
                        'gender'   => $jk === "true" ? 1 : 0,
                    ]);
                }

                return $order; // pastikan return order
        });

            // === Kirim email notifikasi di sini ===
            if ($order) {
                // bridge untuk template yang memakai $order->code
                $order->setAttribute('code', $order->order_code);
                $order->loadMissing(['user','ticket.train','ticket.track']);

                if ($order->user?->email) {
                    try {
                        Mail::to($order->user->email)->send(new OrderCreatedMail($order));
                    } catch (\Throwable $e) {
                        Log::warning('Gagal kirim email order: '.$e->getMessage());
                    }
                }
            }

        } catch (\Throwable $e) {
            Log::error('Order store failed: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withInput()->with('error', $e->getMessage() ?: 'Gagal membuat order. Coba lagi.');
        }

        // redirect ke riwayat transaksi
        return redirect()->route('transactions.index')
            ->with('success', 'Pesanan berhasil ditambahkan!');
    }

    /** Hapus order (kursi ikut terhapus via FK cascade) */
    public function destroy(Order $order)
    {
        if ($trx = Transaction::where('order_id', $order->id)->first()) {
            Transaction::destroy($trx->id);
        }
        $order->delete();
        return redirect('/orders')->with('hapus', 'Data berhasil dihapus!');
    }

    /* =========================
       ===== Helper methods =====
       ========================= */

    /** Kapasitas kursi untuk sebuah train */
    private function capacityForTrain(Train $train): int
    {
        if (is_array($train->layout) && !empty($train->layout)) {
            $c = $this->countSeatsInLayout($train->layout);
            if ($c > 0) return $c;
        }

        if (!empty($train->total_seats) && (int)$train->total_seats > 0) {
            return (int)$train->total_seats;
        }

        if (!empty($train->rows) && (int)$train->rows > 0) {
            return (int)$train->rows * 2; // asumsi 1–aisle–1
        }

        return 11; // default aman
    }

    /** Tentukan layout final untuk frontend */
    private function resolveLayout(Train $train): array
    {
        if (is_array($train->layout) && !empty($train->layout)) {
            return $train->layout;
        }
        $total = $this->capacityForTrain($train);
        return $this->buildAisleLayout1x1($total);
    }

    /** Ambil daftar kode kursi valid dari layout (string persis seperti di FE) */
    private function seatCodesFromLayout(array $layout): array
    {
        $codes = [];
        foreach ($layout as $row) {
            foreach ($row as $cell) {
                if (is_string($cell) && $cell !== "") $codes[] = $cell;
            }
        }
        return array_values(array_unique($codes));
    }

    /** Normalisasi 1 kode kursi agar cocok dengan daftar valid (mis: "1" -> "01") */
    private function normalizeSeatCode(string $raw, array $validCodes): ?string
    {
        $s = strtoupper(trim($raw));

        // Jika sudah persis ada di valid codes, langsung pakai
        if (in_array($s, $validCodes, true)) return $s;

        // Coba cocokkan variasi numerik (01 vs 1)
        if (ctype_digit($s)) {
            $int = (int)$s;
            foreach ($validCodes as $vc) {
                if (ctype_digit($vc) && (int)$vc === $int) {
                    return $vc; // kembalikan format kanonik dari layout (contoh "01")
                }
            }
        }

        // Bisa tambah variasi lain (A1 vs a1), tapi sudah di-uppercase
        return null;
    }

    /** Normalisasi array seat codes berdasar layout train tiket */
    private function normalizeSeatArray(array $seatsRaw, array $validCodes): array
    {
        $norm = [];
        foreach ($seatsRaw as $r) {
            $n = $this->normalizeSeatCode((string)$r, $validCodes);
            if ($n !== null) $norm[] = $n;
        }
        // hilangkan duplikat & reindex
        return array_values(array_unique($norm));
    }

    /** Ambil kursi terisi utk ticket+tanggal dalam format KANONIK sesuai layout */
    private function listOccupiedSeatsNormalized(int $ticketId, string $goDate): array
    {
        $ticket = Ticket::with('train')->findOrFail($ticketId);
        $layout = $this->resolveLayout($ticket->train);
        $valid  = $this->seatCodesFromLayout($layout);

        $raw = [];

        if (Schema::hasTable('order_seats')) {
            $raw = OrderSeat::where('ticket_id', $ticketId)
                ->where('go_date', $goDate)
                ->pluck('seat_code')
                ->toArray();
        } else {
            // fallback dari CSV di orders.selected_seats
            $rows = Order::where('ticket_id', $ticketId)
                ->whereDate('go_date', $goDate)
                ->pluck('selected_seats');

            foreach ($rows as $csv) {
                if (!$csv) continue;
                foreach (explode(',', $csv) as $s) {
                    $s = trim($s);
                    if ($s !== '') $raw[] = $s;
                }
            }
        }

        return $this->normalizeSeatArray($raw, $valid);
    }

    /** Hitung jumlah kursi (cell string non-kosong) dalam layout */
    private function countSeatsInLayout(array $layout): int
    {
        $count = 0;
        foreach ($layout as $row) {
            foreach ($row as $cell) {
                if (is_string($cell) && $cell !== "") $count++;
            }
        }
        return $count;
    }

    /** Generate layout 1–aisle–1: [["01","","02"], ...] */
    private function buildAisleLayout1x1(int $totalSeats): array
    {
        $layout = [];
               $n = 1;
        while ($n <= $totalSeats) {
            $left  = str_pad((string)$n, 2, '0', STR_PAD_LEFT); $n++;
            $right = ($n <= $totalSeats) ? str_pad((string)$n, 2, '0', STR_PAD_LEFT) : "";
            $layout[] = [$left, "", $right];
            $n++;
        }
        return $layout;
    }
}
