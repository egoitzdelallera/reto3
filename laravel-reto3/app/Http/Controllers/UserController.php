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


    public function index()
    {
        //
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



    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
