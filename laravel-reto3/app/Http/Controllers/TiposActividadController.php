<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TiposActividad;

class TiposActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(TiposActividad::all());

    }

    public function show(string $id)
    {
        $tipoActividad = TiposActividad::findOrFail($id);

        return response()->json(['data' => $tipoActividad], 200); // Retorna JSON con el recurso y código 200 OK
    }
}