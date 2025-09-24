<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Transaction $transaction) {}

    public function build()
    {
        $trx   = $this->transaction->load(['order.user','order.ticket.track','order.ticket.train']);
        $order = $trx->order;

        // sebagian template lain pakai $order->code, jembatani dari order_code
        if ($order && empty($order->code) && !empty($order->order_code)) {
            $order->setAttribute('code', $order->order_code);
        }

        return $this->subject('Pembayaran Disetujui - Kode Pesanan: '.($order->order_code ?? $trx->id))
                    ->markdown('emails.transactions.approved', compact('trx','order'));
    }
}
