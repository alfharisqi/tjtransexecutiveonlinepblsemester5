<?php
// app/Http/Controllers/Driver/StatusPerjalananController.php
namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\StatusPerjalanan;
use Illuminate\Http\Request;

class StatusPerjalananController extends Controller
{
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'next_status' => 'required|in:belum_dijemput,perjalanan,tiba_ditujuan',
        ]);

        $status = $order->statusPerjalanan ?: new StatusPerjalanan(['order_id' => $order->id]);
        $status->status = $data['next_status'];
        $status->save();

        return back()->with('success', 'Status perjalanan diperbarui menjadi: '.$status->label);
    }
}
