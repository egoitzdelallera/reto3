<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitor;
use Validator;

class MonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Monitor::all());
    }

    /**
     * Show the form for creating a new resource.
     */
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
            'apellido' => 'required|string|max:255',
            'foto' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $monitor = Monitor::create($request->all());

        return response()->json(['message' => 'Monitor creado correctamente', 'data' => $monitor], 201);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $monitor = Monitor::find($id);

        if (!$monitor) {
            return response()->json(['message' => 'Monitor no encontrado'], 404);
        }

        return response()->json(['data' => $monitor], 200);
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
        $monitor = Monitor::find($id);

        if (!$monitor) {
            return response()->json(['message' => 'Monitor no encontrado'], 404);
        }

        $monitor->update($request->all());

        return response()->json(['message' => 'Monitor actualizado correctamente', 'data' => $monitor], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $monitor = Monitor::find($id);

        if (!$monitor) {
            return response()->json(['message' => 'Monitor no encontrado'], 404);
        }
        $monitor->delete();
        return response()->json(['message' => 'Monitor eliminado correctamente'], 200);
    }
}
