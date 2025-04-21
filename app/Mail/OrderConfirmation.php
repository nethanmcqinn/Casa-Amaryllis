<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.receipt', ['order' => $this->order]);
        
        return $this->subject('Order Confirmation - Casa Amaryllis')
                    ->view('emails.orders.confirmation')
                    ->attachData($pdf->output(), 'receipt_' . $this->order->id . '.pdf');
    }
}
