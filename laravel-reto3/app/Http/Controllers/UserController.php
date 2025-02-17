<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendInscriptionEmail;
use Validator;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    

    public function login(Request $request)
    {
        // Validar las credenciales
        $credentials = $request->validate([
            'correo' => 'required|email',
            'password' => 'required|string',
        ]);

        // Intentar autenticar con las credenciales
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Correo o contraseña inválidos'], 401);
        }

        // Obtener el usuario autenticado
        $user = auth()->user();

        // Definir los claims personalizados
        $customClaims = [
            'id' => $user->id,
            'nombre' => $user->nombre,
            'correo' => $user->correo,
            'tipo' => $user->tipo,
            'telefono' => $user->telefono
        ];

        // Generar el token con los claims personalizados
        $token = JWTAuth::fromUser($user, $customClaims);

        // Devolver el token junto con el tipo
        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function inscribir(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido1' => 'required|string|max:255',
            'apellido2' => 'required|string|max:255',
            'dni' => 'nullable|string|max:20',
            'sexo' => 'required|in:hombre,mujer',
            'edad' => 'required|integer|min:0',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|string|email|max:255',
            'id_actividad' => 'required|exists:actividades,id',
        ]);

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

        // Preparar los datos para el correo electrónico
        $inscriptionData = [
            'nombre' => $user->nombre,
            'apellido1' => $user->apellido1,
            'apellido2' => $user->apellido2,
            'dni' => $user->dni,
            'sexo' => $user->sexo,
            'edad' => $user->edad,
            'telefono' => $user->telefono,
            'correo' => $user->correo,
            'actividad_nombre' => $request->input('id_actividad'), //TODO: get actividad_nombre from id
        ];

        // Enviar el correo electrónico usando el Job
        SendInscriptionEmail::dispatch($inscriptionData, $user->correo);


        return response()->json(['message' => 'Inscripción realizada correctamente', 'user' => $user], 201);
    }


    public function logout(Request $request)
    {
        try {
            // Obtener el token del encabezado de la solicitud
            $token = JWTAuth::getToken();

            if (!$token) {
                return response()->json(['error' => 'Token no encontrado'], 400);
            }

            // Invalidar el token
            JWTAuth::invalidate($token);

            return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token inválido'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Error al cerrar sesión, token no procesable'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error inesperado'], 500);
        }
    }

    public function index(Request $request)
    {
        $users = User::select('id', 'nombre', 'correo', 'tipo', 'telefono')
            ->get();

        return response()->json($users);
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:users,correo',
            'tipo' => 'required|in:admin,ciudadano',
            'telefono' => 'nullable|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = new User();
        $user->nombre = $request->input('nombre');
        $user->correo = $request->input('correo');
        $user->tipo = $request->input('tipo');
        $user->telefono = $request->input('telefono');
        $user->password = Hash::make($request->input('password'));

        $user->save();

        return response()->json(['message' => 'Usuario creado correctamente', 'user' => $user]);
    }


    public function user(Request $request)
    {
        try {
            // Obtener el usuario autenticado a través del token
            $user = JWTAuth::parseToken()->authenticate();

            // Buscar el usuario en la base de datos con los campos adecuados
            $userData = User::select('id', 'nombre', 'correo', 'tipo', 'telefono')
                ->find($user->id);

            if (!$userData) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }

            return response()->json($userData);
            
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['message' => 'Token expirado'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['message' => 'Token inválido'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['message' => 'Token ausente'], 401);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
