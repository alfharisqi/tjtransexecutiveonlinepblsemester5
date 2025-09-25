<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Train;
use App\Models\Track;
use App\Models\Price;
use App\Models\Driver; // <-- tambah import Driver
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->authorize('isAdmin');

        // if (Gate::allows('isAdmin')) {
        return view('dashboard.ticket.index', [
            'tickets' => Ticket::all()->load('price'), // tetap seperti semula
            'trains'  => Train::all(),
            'tracks'  => Track::all(),
            'drivers' => Driver::select('id','nama_driver')->orderBy('nama_driver')->get(), // <-- kirim ke view
        ]);
        // } else {
        //     // akses logic untuk user selain role admin
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('admin.dashboard.ticket.index', [
        //     'trains' => Train::all(),
        //     'tracks' => Track::all()
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $data = $request->validate([
        'train_id'        => ['required','exists:trains,id'],
        'track_id'        => ['required','exists:tracks,id'],
        'driver_id'       => ['required','exists:drivers,id'],
        'price'           => ['required','numeric','min:0'],
        'departure_date'  => ['required','date'],
        'departure_time'  => ['required','date_format:H:i'],
        'arrival_date'    => ['required','date'],
        'arrival_time'    => ['required','date_format:H:i'],
    ]);

    // Gabungkan tanggal + jam tanpa konversi timezone
    $departureAt = $data['departure_date'].' '.$data['departure_time']; // hasil string: 2025-09-04 09:00
    $arrivalAt   = $data['arrival_date'].' '.$data['arrival_time'];

    if (strtotime($arrivalAt) < strtotime($departureAt)) {
        return back()->withInput()->with('error', 'Waktu tiba tidak boleh lebih awal dari waktu berangkat.');
    }

    $ticket = Ticket::create([
        'train_id'     => $data['train_id'],
        'track_id'     => $data['track_id'],
        'driver_id'    => $data['driver_id'],
        'departure_at' => $departureAt,
        'arrival_at'   => $arrivalAt,
    ]);

    Price::create(['ticket_id' => $ticket->id, 'price' => $data['price']]);

    return redirect('/tickets')->with('success', 'Tiket berhasil ditambahkan.');
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
{
    $data = $request->validate([
        'train_id'        => ['required','exists:trains,id'],
        'track_id'        => ['required','exists:tracks,id'],
        'departure_date'  => ['required','date'],
        'departure_time'  => ['required','date_format:H:i'],
        'arrival_date'    => ['required','date'],
        'arrival_time'    => ['required','date_format:H:i'],
    ]);

    $departureAt = $data['departure_date'].' '.$data['departure_time'];
    $arrivalAt   = $data['arrival_date'].' '.$data['arrival_time'];

    if (strtotime($arrivalAt) < strtotime($departureAt)) {
        return back()->withInput()->with('error', 'Waktu tiba tidak boleh lebih awal dari waktu berangkat.');
    }

    $ticket->update([
        'train_id'     => $data['train_id'],
        'track_id'     => $data['track_id'],
        'departure_at' => $departureAt,
        'arrival_at'   => $arrivalAt,
    ]);

    return redirect('/tickets')->with('success', 'Tiket berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->destroy($ticket->id);
        return redirect('/tickets')->with('delete', "Tiket berhasil dihapus!");
    }
}
