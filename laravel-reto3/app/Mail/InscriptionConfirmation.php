<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InscriptionConfirmation extends Mailable implements ShouldQueue // Implement ShouldQueue
{
    use Queueable, SerializesModels;

    public $inscriptionData;

    /**
     * Create a new message instance.
     *
     * @param array $inscriptionData
     */
    public function __construct(array $inscriptionData)
    {
        $this->inscriptionData = $inscriptionData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirmación de Inscripción')
                    ->view('emails.inscription_confirmation') // Path to your email view
                    ->with('inscriptionData', $this->inscriptionData);  // Pass inscriptionData to the view
    }
}