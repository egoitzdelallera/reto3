<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\InscriptionConfirmation;
use Illuminate\Support\Facades\Log;

class SendInscriptionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inscriptionData;
    protected $userEmail;

    /**
     * Create a new job instance.
     *
     * @param  array  $inscriptionData
     * @param  string  $userEmail
     * @return void
     */
    public function __construct(array $inscriptionData, string $userEmail)
    {
        $this->inscriptionData = $inscriptionData;
        $this->userEmail = $userEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Mail::to($this->userEmail)->send(new InscriptionConfirmation(
                $this->inscriptionData['nombre'],
                $this->inscriptionData['actividad_nombre']
            ));
        } catch (\Exception $e) {
            Log::error('Error sending inscription confirmation email: ' . $e->getMessage());
        }
    }
}