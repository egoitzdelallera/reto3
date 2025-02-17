<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;
use App\Services\PHPMailerService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\SendEmailJob;
use Validator;
use Illuminate\Support\Facades\Mail;


class CorreoController extends Controller
{
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'correo' => 'required|string|email|max:255',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'mensaje' => 'required|string|max:1000',
        ]);


        Mail::to('inigoberastegi@gmail.com')->send(new TestMail($validator));
        /*
        if ($validator->fails()) {
            return response()->json(['message' => 'Error de validación', 'errors' => $validator->errors()], 422);
        }

        $emailData = [
            'correo' => $request->input('correo'),
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'mensaje' => $request->input('mensaje'),
        ];

        // Dispatch the job to send the email
        SendEmailJob::dispatch($emailData);

        return response()->json(['message' => 'Correo enviado correctamente'], 201);
    }
        */
        
}
}
