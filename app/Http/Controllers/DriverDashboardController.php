<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Carbon\Carbon;

class DriverDashboardController extends Controller
{
    public function index(Request $request)
    {
        $driver = auth('driver')->user();

        $driverTickets = Ticket::with([
            'price','train','track',
            'orders.passengers',
            'orders.user',
            'orders.statusPerjalanan',   // <-- TAMBAHKAN INI
        ])
        ->where('driver_id', $driver->id)
        ->orderBy('departure_at','asc')
        ->get();

        $nowWIB = Carbon::now('Asia/Jakarta');
        $upcoming = $driverTickets->filter(function ($t) use ($nowWIB) {
            return optional($t->departure_at)->gt($nowWIB->copy()->utc());
        });

        return view('dashboard.driver.dashboard', [
            'driver'        => $driver,
            'driverTickets' => $driverTickets,
            'upcoming'      => $upcoming,
        ]);
    }
}
