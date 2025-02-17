<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\InscriptionConfirmation;
use Illuminate\Support\Facades\Mail;

class SendInscriptionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inscriptionData;
    protected $email;

    /**
     * Create a new job instance.
     */
    public function __construct(array $inscriptionData, string $email)
    {
        $this->inscriptionData = $inscriptionData;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
         Mail::to($this->email)->send(new InscriptionConfirmation($this->inscriptionData));
    }
}