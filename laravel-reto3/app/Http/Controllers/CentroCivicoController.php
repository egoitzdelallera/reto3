<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CentroCivico;
use Validator;

class CentroCivicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(CentroCivico::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'longitud' => 'required|numeric',
            'latitud' => 'required|numeric',
            'url' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $centroCivico = CentroCivico::create($request->all());
        return response()->json(['message' => 'Centro cívico creado correctamente', 'data' => $centroCivico], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $centroCivico = CentroCivico::find($id);

        if (!$centroCivico) {
            return response()->json(['message' => 'Centro cívico no encontrado'], 404);
        }

        return response()->json($centroCivico);
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
        $centroCivico = CentroCivico::find($id);

        if (!$centroCivico) {
            return response()->json(['message' => 'Centro cívico no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|string|max:255',
            'ubicacion' => 'sometimes|string|max:255',
            'longitud' => 'sometimes|numeric',
            'latitud' => 'sometimes|numeric',
            'url' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:255',
            'correo' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $centroCivico->update($request->all());
        return response()->json(['message' => 'Centro cívico actualizado correctamente', 'data' => $centroCivico]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $centroCivico = CentroCivico::find($id);

        if (!$centroCivico) {
            return response()->json(['message' => 'Centro cívico no encontrado'], 404);
        }

        $centroCivico->delete();
        return response()->json(['message' => 'Centro cívico eliminado correctamente'], 200);
    }
}
