<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Expense;
use App\Models\Ticket;
use App\Models\ExpensePreset;
use Carbon\Carbon;

class FinanceController extends Controller
{
    public function summary(Request $r)
    {
        // ========== PILIHAN PERIODE ==========
        // mode: day | month | year (default: month)
        $mode = $r->input('mode', 'month');

        if ($mode === 'day') {
            $date = $r->date('date') ?? Carbon::today();
            $from = $date->copy()->startOfDay();
            $to   = $date->copy()->endOfDay();

            $valDate  = $date;
            $valMonth = null;
            $valYear  = null;
        } elseif ($mode === 'year') {
            $year = (int) ($r->input('year') ?? Carbon::now()->year);
            $from = Carbon::create($year, 1, 1)->startOfDay();
            $to   = Carbon::create($year, 12, 31)->endOfDay();

            $valDate  = null;
            $valMonth = null;
            $valYear  = $year;
        } else { // month
            $ym = $r->input('month'); // format: Y-m
            if ($ym) {
                [$y,$m] = explode('-', $ym);
                $first  = Carbon::createFromDate((int)$y, (int)$m, 1);
            } else {
                $first = Carbon::now()->startOfMonth();
            }
            $from = $first->copy()->startOfDay();
            $to   = $first->copy()->endOfMonth()->endOfDay();

            $valDate  = null;
            $valMonth = $first->format('Y-m');
            $valYear  = null;
        }

        $fromStart = $from->copy()->startOfDay();
        $toEnd     = $to->copy()->endOfDay();

        // ========== REKAP PER TIKET ==========
        $fromDateSql = $from->toDateString();
        $toDateSql   = $to->toDateString();

        $perTicket = DB::table('tickets')
            ->leftJoin('orders', 'orders.ticket_id', '=', 'tickets.id')
            ->leftJoin('transactions', 'transactions.order_id', '=', 'orders.id')
            ->leftJoin('expenses', 'expenses.ticket_id', '=', 'tickets.id')
            ->select(
                'tickets.id',
                DB::raw("COALESCE(SUM(CASE
                    WHEN transactions.status = 1
                     AND transactions.created_at BETWEEN '{$fromStart}' AND '{$toEnd}'
                    THEN transactions.total ELSE 0 END),0) AS total_income"),
                DB::raw("COALESCE(SUM(CASE
                    WHEN transactions.status = 1
                     AND transactions.created_at BETWEEN '{$fromStart}' AND '{$toEnd}'
                    THEN (CASE
                        WHEN orders.selected_seats IS NULL OR orders.selected_seats = ''
                        THEN 0
                        ELSE (LENGTH(orders.selected_seats) - LENGTH(REPLACE(orders.selected_seats, ',', '')) + 1)
                    END)
                    ELSE 0 END),0) AS seats_sold"),
                DB::raw("COALESCE(SUM(CASE
                    WHEN transactions.status = 1
                     AND transactions.created_at BETWEEN '{$fromStart}' AND '{$toEnd}'
                    THEN 1 ELSE 0 END),0) AS paid_orders"),
                DB::raw("COALESCE(SUM(CASE
                    WHEN expenses.date BETWEEN '{$fromDateSql}' AND '{$toDateSql}'
                    THEN expenses.amount ELSE 0 END),0) AS expense_total")
            )
            ->groupBy('tickets.id')
            ->orderByDesc('total_income')
            ->get()
            ->map(function ($row) {
                $row->net = (int)$row->total_income - (int)$row->expense_total;
                return $row;
            });

        // Biaya umum (tanpa ticket_id) dalam range
        $generalExpense = Expense::whereNull('ticket_id')
            ->whereBetween('date', [$from, $to])
            ->sum('amount');

        // GRAND TOTAL
        $gross   = (int) $perTicket->sum('total_income');
        $expense = (int) $perTicket->sum('expense_total') + (int) $generalExpense;
        $net     = $gross - $expense;

        // Rekap harian (berdasarkan transaksi approved)
        $daily = Transaction::where('status', 1)
            ->selectRaw('DATE(created_at) as d, SUM(total) as gross')
            ->whereBetween('created_at', [$fromStart, $toEnd])
            ->groupBy('d')
            ->orderBy('d')
            ->get()
            ->map(function ($row) {
                $row->expense = Expense::whereDate('date', $row->d)->sum('amount');
                $row->net = $row->gross - $row->expense;
                return $row;
            });

        // daftar biaya, tiket, dan preset untuk form
        $expenses = Expense::whereBetween('date', [$from, $to])->latest('date')->get();
        $tickets  = Ticket::select('id')->orderBy('id')->get();
        $presets  = ExpensePreset::where('is_active', true)->orderBy('name')->get();

        return view('dashboard.finance.index', compact(
            'mode','valDate','valMonth','valYear',
            'from','to','gross','expense','net','daily','expenses','perTicket','tickets','presets'
        ));
    }

    // ===== CRUD BIAYA =====
    public function storeExpense(Request $r)
    {
        // amount dibuat nullable karena bisa diisi dari preset
        $data = $r->validate([
            'date'       => 'required|date',
            'ticket_id'  => 'nullable|exists:tickets,id',
            'preset_id'  => 'nullable|exists:expense_presets,id',
            'category'   => 'nullable|string|max:100',
            'amount'     => 'nullable|integer|min:0',
            'note'       => 'nullable|string',
        ]);

        // Jika ada preset, auto-isi category/amount jika kosong
        if (!empty($data['preset_id'])) {
            $preset = ExpensePreset::find($data['preset_id']);
            if ($preset) {
                $data['category'] = $data['category'] ?: $preset->name;
                $data['amount']   = isset($data['amount']) ? $data['amount'] : (int) $preset->amount;
            }
            unset($data['preset_id']); // kolom ini tidak ada di tabel expenses
        }

        // Safety: pastikan nominal terisi dari salah satu sumber
        if (!isset($data['amount'])) {
            return back()
                ->withErrors(['amount' => 'Isi nominal atau pilih preset dengan nominal.'])
                ->withInput();
        }

        Expense::create($data);
        return back()->with('ok', 'Biaya tersimpan');
    }


    public function destroyExpense(Expense $expense)
    {
        $expense->delete();
        return back()->with('ok', 'Biaya terhapus');
    }
}
