<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendInscriptionEmail;
use Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Actividad;  // Add this line to import the Actividad model


class UserController extends Controller
{
    public function login(Request $request)
    {
        // ... your login logic here ...
    }

    public function inscribir(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'dni' => 'required|string|max:9',
            'nombre' => 'required|string|max:255',
            'apellido1' => 'required|string|max:255',
            'apellido2' => 'required|string|max:255',
            'sexo' => 'required|in:hombre,mujer',
            'edad' => 'required|integer|min:0',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|string|email|max:255',
            'id_actividad' => 'required|exists:actividades,id',
        ]);

          \Log::info("inscribir has passed validators");

        if ($validator->fails()) {
            return response()->json(['message' => 'Error de validación', 'errors' => $validator->errors()], 422);
        }

        $nombre_completo = $request->input('nombre') . ' ' . $request->input('apellido1') . ' ' . $request->input('apellido2');

        $user = new User();
        $user->nombre = $nombre_completo;
        $user->dni = $request->input('dni');
        $user->sexo = $request->input('sexo');
        $user->edad = $request->input('edad');
        $user->telefono = $request->input('telefono');
        $user->correo = $request->input('correo');
        $user->password = Hash::make(uniqid()); // Contraseña aleatoria
        $user->save();
        \Log::info("Inscribir has saved the user, ".$user["correo"]);

        // Guardar en la tabla actividades_usuarios
        \DB::table('actividades_usuarios')->insert([
            'id_actividad' => $request->input('id_actividad'),
            'id_usuario' => $user->id,
        ]);

        // Retrieve the activity information
        $actividad = Actividad::find($request->input('id_actividad'));

        // Preparar los datos para el correo electrónico
        $inscriptionData = [
            'nombre' => $request->input('nombre'),
            'apellido1' => $request->input('apellido1'),
            'apellido2' => $request->input('apellido2'),
            'dni' => $request->input('dni'),
            'sexo' => $request->input('sexo'),
            'edad' => $request->input('edad'),
            'telefono' => $request->input('telefono'),
            'correo' => $request->input('correo'),
            'actividad_nombre' => $actividad ? $actividad->nombre : 'Nombre de la Actividad', // Use activity name or default
        ];
               \Log::info("Data array has been made");
               \Log::info("email to pass  is".$inscriptionData['correo']);

        // Enviar el correo electrónico usando the job
        SendInscriptionEmail::dispatch($inscriptionData, $user->correo);
        \Log::info("Passed dispatch call");
        return response()->json(['message' => 'Inscripción realizada correctamente', 'user' => $user], 201);
    }

    public function logout(Request $request)
    {
        // ... your logout logic here ...
    }

    public function index(Request $request)
    {
        // ... your index logic here ...
    }

    public function store(Request $request)
    {
        // ... your store logic here ...
    }

    public function user(Request $request)
    {
        // ... your user logic here ...
    }

    public function update(Request $request, string $id)
    {
        // ... your update logic here ...
    }

    public function destroy(string $id)
    {
        // ... your destroy logic here ...
    }
}