<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;



class InscriptionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $actividadNombre;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $nombre, string $actividadNombre)
    {
        $this->nombre = $nombre;
        $this->actividadNombre = $actividadNombre;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Inscripción Confirmada')
                    ->view('emails.inscripcion_confirmada'); // Asume que tienes una vista en resources/views/emails/inscripcion_confirmada.blade.php
    }
}