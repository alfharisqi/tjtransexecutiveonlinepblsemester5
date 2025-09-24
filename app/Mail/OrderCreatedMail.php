<?php
// app/Mail/OrderCreatedMail.php
namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function build()
    {
        $order = $this->order->loadMissing(['user','ticket.train','ticket.track']);
        return $this->subject('Pesanan Diterima: '.$order->code)
            ->markdown('emails.orders.created', compact('order'));
    }
}
