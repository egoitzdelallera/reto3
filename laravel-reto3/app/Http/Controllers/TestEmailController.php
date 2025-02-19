<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;  // Create this Mailable (see below)
use App\Services\PHPMailerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestEmailController extends Controller
{
    protected $phpMailerService;
    public function __construct(PHPMailerService $phpMailerService)
    {
        $this->phpMailerService = $phpMailerService;
    }
    public function sendTestEmail(Request $request)
    {
        try {
           $email=$request["email"];
           $token = localStorage()->get("access_token");

           $token = localStorage("access_token");
            $this->phpMailerService->sendEmail($email, 'Test Email from Laravel','
              <!DOCTYPE html>
              <html>
              <head>
                  <title>Confirmación de Inscripción</title>
              </head>
              <body>
                  <h1>Test Confirmada!</h1>
                  <p>Hola Test,</p>
                  <p>Token<p>'.token . '</p>
                  <p>¡Te esperamos!</p>
              </body>
              </html>
           ');

            return "Test email sent successfully!";
        } catch (\Exception $e) {
            return "Error sending test email: " . $e->getMessage();
        }
    }
}