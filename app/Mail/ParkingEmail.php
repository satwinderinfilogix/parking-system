<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ParkingEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $parking;
    /**
     * Create a new message instance.
     */
    public function __construct($parking)
    {
        $this->parking = $parking;
    }

    public function build()
    {
        return $this->view('emails.parking')
                    ->with(['parking' => $this->parking]);
    }
}
