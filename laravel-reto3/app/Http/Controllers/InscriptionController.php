<?php

namespace App\Http\Controllers;

use App\Services\PHPMailerService;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
    protected $phpMailerService;

    public function __construct(PHPMailerService $phpMailerService)
    {
        $this->phpMailerService = $phpMailerService;
    }

    public function inscribir(Request $request)
    {
        // ... your inscription validation and save logic here ...

        $inscriptionData = $request->all();
        $to = $inscriptionData['correo'];
        $subject = 'Confirmación de Inscripción';
        $body = "<p>Hola " . $inscriptionData['nombre'] . ",</p><p>Te has inscrito correctamente.</p>";

        if ($this->phpMailerService->sendEmail($to, $subject, $body)) {
            return response()->json(['message' => 'Inscripción realizada con éxito. Se ha enviado un correo de confirmación.']);
        } else {
            return response()->json(['message' => 'Inscripción realizada, pero hubo un problema al enviar el correo de confirmación.'], 500);
        }
    }
}