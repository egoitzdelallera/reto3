<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TiposActividad;
use Validator;

class TiposActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(TiposActividad::all());

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'multimedia' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tipoActividad = TiposActividad::create($request->all());

        return response()->json(['message' => 'Tipo de actividad creado correctamente', 'data' => $tipoActividad], 201);
    }

    public function update(Request $request, string $id)
    {
        $tiposActividad = TiposActividad::find($id);

        if (!$tiposActividad) {
            return response()->json(['message' => 'Tipo de actividad no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'multimedia' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tiposActividad->update($request->all());

        return response()->json(['message' => 'Actualización exitosa', 'data' => $tiposActividad], 200);
    }

    public function show(string $id)
    {
        $tipoActividad = TiposActividad::findOrFail($id);

        return response()->json(['data' => $tipoActividad], 200); // Retorna JSON con el recurso y código 200 OK
    }
}