<?php

namespace App\Http\Controllers;

use App\Models\Train;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TrainController extends Controller
{
    public function index()
    {
        return view('dashboard.train.index', [
            'trains' => Train::orderBy('id','desc')->get()
        ]);
    }

    public function create() { /* not used */ }
    public function show(Train $train) { /* not used */ }
    public function edit(Train $train) { /* not used */ }

    public function store(Request $request)
    {
        // ===== Validasi =====
        $rules = [
            'name'         => ['required','string','min:3','max:50'],
            'class'        => ['required','string','min:3','max:10'],
            'nopol'        => ['required','string','max:20','unique:trains,nopol'],
            // FOTO BARU
            'foto_armada'  => ['nullable','image','max:2048'], // 2MB
            'foto_kursi'   => ['nullable','image','max:2048'],

            // seat config (sesuai FORM)
            'total_seats'  => ['nullable','integer','min:0'],
            'rows'         => ['nullable','integer','min:0'],
            'cols'         => ['nullable','integer','min:0'],
            'layout'       => ['nullable','json'],
        ];

        $messages = [
            'foto_armada.image' => 'Foto armada harus berupa gambar.',
            'foto_armada.max'   => 'Ukuran foto armada maksimal 2 MB.',
            'foto_kursi.image'  => 'Foto kursi harus berupa gambar.',
            'foto_kursi.max'    => 'Ukuran foto kursi maksimal 2 MB.',
            'nopol.unique'      => 'Nomor plat sudah terdaftar.',
            'layout.json'       => 'Layout harus berformat JSON yang valid.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('/trains')
                ->withErrors($validator)
                ->withInput()
                ->with('openCreate', true);
        }

        // Cegah duplikasi kombinasi name + class (opsional)
        $existsCombo = Train::where('name', $request->name)
            ->where('class', $request->class)
            ->exists();
        if ($existsCombo) {
            return redirect('/trains')
                ->with('sameTrain', 'Armada dengan kombinasi nama & kelas yang sama sudah ada!')
                ->with('openCreate', true)
                ->withInput();
        }

        // ===== Siapkan data simpan =====
        $data = $validator->validated();

        // Simpan foto jika diunggah
        if ($request->hasFile('foto_armada')) {
            $data['foto_armada'] = $request->file('foto_armada')->store('trains', 'public');
        }
        if ($request->hasFile('foto_kursi')) {
            $data['foto_kursi'] = $request->file('foto_kursi')->store('trains', 'public');
        }

        // Seat config (map ke kolom DB: rows/cols + layout array)
        [$total, $rows, $cols, $layout] = $this->prepareSeatConfigFromRequest($request, null);
        $data['total_seats'] = $total;
        $data['rows']        = $rows;
        $data['cols']        = $cols;
        $data['layout']      = $layout; // pastikan di Model: protected $casts=['layout'=>'array'];

        Train::create($data);

        return redirect('/trains')->with('store', 'Data Armada Berhasil Ditambahkan!');
    }

    public function update(Request $request, Train $train)
    {
        // ===== Validasi =====
        $rules = [
            'name'         => ['required','string','min:3','max:50'],
            'class'        => ['required','string','min:3','max:10'],
            'nopol'        => ['required','string','max:20','unique:trains,nopol,'.$train->id],
            // FOTO BARU
            'foto_armada'  => ['nullable','image','max:2048'],
            'foto_kursi'   => ['nullable','image','max:2048'],

            // seat config (sesuai FORM)
            'total_seats'  => ['nullable','integer','min:0'],
            'rows'         => ['nullable','integer','min:0'],
            'cols'         => ['nullable','integer','min:0'],
            'layout'       => ['nullable','json'],
        ];

        $messages = [
            'foto_armada.image' => 'Foto armada harus berupa gambar.',
            'foto_armada.max'   => 'Ukuran foto armada maksimal 2 MB.',
            'foto_kursi.image'  => 'Foto kursi harus berupa gambar.',
            'foto_kursi.max'    => 'Ukuran foto kursi maksimal 2 MB.',
            'nopol.unique'      => 'Nomor plat sudah terdaftar.',
            'layout.json'       => 'Layout harus berformat JSON yang valid.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('/trains')
                ->withErrors($validator)
                ->withInput()
                ->with('openEditId', $train->id);
        }

        // Duplikat name+class utk id lain (opsional)
        $existsCombo = Train::where('id','!=',$train->id)
            ->where('name', $request->name)
            ->where('class', $request->class)
            ->exists();
        if ($existsCombo) {
            return redirect('/trains')
                ->with('sameTrain', 'Armada dengan kombinasi nama & kelas yang sama sudah ada!')
                ->with('openEditId', $train->id)
                ->withInput();
        }

        // ===== Siapkan data update =====
        $data = $validator->validated();

        // Ganti foto jika ada unggahan baru
        if ($request->hasFile('foto_armada')) {
            if ($train->foto_armada) {
                Storage::disk('public')->delete($train->foto_armada);
            }
            $data['foto_armada'] = $request->file('foto_armada')->store('trains', 'public');
        }
        if ($request->hasFile('foto_kursi')) {
            if ($train->foto_kursi) {
                Storage::disk('public')->delete($train->foto_kursi);
            }
            $data['foto_kursi'] = $request->file('foto_kursi')->store('trains', 'public');
        }

        // Seat config
        [$total, $rows, $cols, $layout] = $this->prepareSeatConfigFromRequest($request, $train);
        $data['total_seats'] = $total;
        $data['rows']        = $rows;
        $data['cols']        = $cols;
        $data['layout']      = $layout;

        $train->update($data);

        return redirect('/trains')->with('update', 'Data Armada Berhasil Diubah!');
    }

    public function destroy(Train $train)
    {
        // Hapus file lama bila ada
        if ($train->foto_armada) {
            Storage::disk('public')->delete($train->foto_armada);
        }
        if ($train->foto_kursi) {
            Storage::disk('public')->delete($train->foto_kursi);
        }

        $train->delete();
        return redirect('/trains')->with('delete', 'Data Armada Berhasil Dihapus');
    }

    /**
     * Ambil seat config dari request (nama input: total_seats, rows, cols, layout)
     * dan kembalikan sebagai [total, rows, cols, layoutArray]
     */
    private function prepareSeatConfigFromRequest(Request $request, ?Train $existing = null): array
    {
        // Nilai dasar (pakai request; fallback ke existing)
        $total = $this->intOrNull($request->input('total_seats', $existing->total_seats ?? null));
        $rows  = $this->intOrNull($request->input('rows',        $existing->rows        ?? null));
        $cols  = $this->intOrNull($request->input('cols',        $existing->cols        ?? null));

        // Parse layout jika ada
        $layoutRaw = $request->input('layout');
        $layoutArr = null;
        if (is_string($layoutRaw) && strlen(trim($layoutRaw)) > 0) {
            $layoutArr = json_decode($layoutRaw, true);
            if (!is_array($layoutArr)) $layoutArr = null;
        }

        // Jika layout tidak disediakan tapi total_seats ada → generate default 1–aisle–1
        if ($layoutArr === null && $total !== null && $total > 0) {
            if ($cols === null || $cols <= 0) $cols = 3;
            $layoutArr = $this->buildAisleLayout1x1($total); // [["01","","02"], ...]
        }

        // Hitung rows jika belum diisi tapi layout ada
        if (($rows === null || $rows <= 0) && is_array($layoutArr)) {
            $rows = count($layoutArr);
        }
        // Kalau rows masih kosong dan total ada → asumsi 2 kursi per baris (1 kiri + 1 kanan)
        if (($rows === null || $rows <= 0) && $total) {
            $rows = (int) ceil($total / 2);
        }

        // Normalisasi cols bila layout ada
        if (($cols === null || $cols <= 0) && is_array($layoutArr) && isset($layoutArr[0]) && is_array($layoutArr[0])) {
            $cols = count($layoutArr[0]);
        }

        // Total seats dari layout jika belum ada
        if (($total === null || $total <= 0) && is_array($layoutArr)) {
            $total = $this->countSeatsInLayout($layoutArr);
        }

        return [
            $total ?? 0,
            $rows  ?? 0,
            $cols  ?? 0,
            $layoutArr, // disimpan sebagai JSON via casts di Model
        ];
    }

    private function intOrNull($v): ?int
    {
        if ($v === null || $v === '') return null;
        return (int) $v;
    }

    /**
     * Generate layout 1–aisle–1 dari total seats:
     * [["01","","02"], ["03","","04"], ..., ["11","",""]]
     */
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
}
