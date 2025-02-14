<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use Validator;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Actividad::all());
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
            'descripcion' => 'required|string|max:255',
            'id_tipo_actividad' => 'required|exists:tipos_actividades,id',
            'id_centro_civico' => 'required|exists:centros_civicos,id',
            'id_monitor' => 'required|exists:monitores,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $actividad = new Actividad();
        $actividad->nombre = $request->input('nombre');
        $actividad->descripcion = $request->input('descripcion');
        $actividad->id_tipo_actividad = $request->input('id_tipo_actividad');
        $actividad->id_centro_civico = $request->input('id_centro_civico');
        $actividad->id_monitor = $request->input('id_monitor');

        $actividad->save();

        return response()->json(['message' => 'Actividad creada correctamente', 'actividad' => $actividad]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $actividades = Actividad::where('id_tipo_actividad', $id)
            ->with(['centroCivico', 'monitor', 'tipoActividad', 'horarios']) // Eager load relationships
            ->get();
    
        // Add this line for debugging:
        // dd($actividades->toArray());
    
        if ($actividades->isEmpty()) {
            return response()->json(['message' => 'No se encontraron actividades para el tipo de actividad especificado'], 404);
        }
    
        return response()->json($actividades);
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
        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string|max:255',
            'id_tipo_actividad' => 'sometimes|exists:tipos_actividades,id',
            'id_centro_civico' => 'sometimes|exists:centros_civicos,id',
            'id_monitor' => 'sometimes|exists:monitores,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $actividad = Actividad::find($id);

        if (!$actividad) {
            return response()->json(['message' => 'Actividad no encontrada'], 404);
        }

        if ($request->has('nombre')) {
            $actividad->nombre = $request->input('nombre');
        }
        if ($request->has('descripcion')) {
            $actividad->descripcion = $request->input('descripcion');
        }
        if ($request->has('id_tipo_actividad')) {
            $actividad->id_tipo_actividad = $request->input('id_tipo_actividad');
        }
        if ($request->has('id_centro_civico')) {
            $actividad->id_centro_civico = $request->input('id_centro_civico');
        }
        if ($request->has('id_monitor')) {
            $actividad->id_monitor = $request->input('id_monitor');
        }

        $actividad->save();

        return response()->json(['message' => 'Actividad actualizada correctamente', 'actividad' => $actividad]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $actividad = Actividad::find($id);

        if (!$actividad) {
            return response()->json(['message' => 'Actividad no encontrada'], 404);
        }

        $actividad->delete();

        return response()->json(['message' => 'Actividad eliminada correctamente'], 200);
    }
}