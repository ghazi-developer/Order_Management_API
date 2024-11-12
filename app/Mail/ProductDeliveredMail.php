<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProductDeliveredMail extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    public $orderDetails;
    public function __construct(Order $order,$orderDetails)
    {
         $this->order = $order;
         $this->orderDetails = $orderDetails;
    }

    public function build()
    {
    $this->order->load('product', 'client');
    return $this->subject('Your Order has been Delivered')
                ->view('emails.order_delivered')
                ->with([
                    'order' => $this->order,
                    'orderDetails'=>$this->orderDetails
                ]);
    }
}
