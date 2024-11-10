<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProductDeliveredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $client;

    public function __construct($product, $client)
    {
        $this->product = $product;
        $this->client = $client;
    }

    public function build()
    {
        return response()->json($this->subject);
    }
}
