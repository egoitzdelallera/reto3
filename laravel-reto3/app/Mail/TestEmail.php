<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable implements ShouldQueue // ShouldQueue or not, your choice for testing
{
    use Queueable, SerializesModels;
    public $subject = 'Mensaje del Ayuntamiento';
    public $contenido;

    public function __construct()
    {
        $this->contenido=$contenido;
    }

    public function build()
    {
        return $this->subject('Test Email from Laravel')
                    ->view('emails.test'); // Create resources/views/emails/test.blade.php
    }
}