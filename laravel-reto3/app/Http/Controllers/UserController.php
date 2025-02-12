<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


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
            'telefono' => $user->telefono,
        ];

        // Generar el token con los claims personalizados
        $token = JWTAuth::fromUser($user, $customClaims);

        // Devolver el token junto con el tipo
        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function register(Request $request)
    {
        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:users,correo',
            'tipo' => 'required|string|max:50',
            'telefono' => 'nullable|string|max:15',
            'password' => 'required|string|min:6|confirmed'
        ]);

        // Retornar errores si la validación falla
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Crear el usuario
        $user = new User();
        $user->nombre = $request->input('nombre');
        $user->correo = $request->input('correo');
        $user->tipo = $request->input('tipo');
        $user->telefono = $request->input('telefono');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Reclamos personalizados para el token
        $customClaims = [
            'id' => $user->id,
            'nombre' => $user->nombre,
            'correo' => $user->correo,
            'tipo' => $user->tipo,
            'telefono' => $user->telefono,
        ];

        // Generar el token
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 201);
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
