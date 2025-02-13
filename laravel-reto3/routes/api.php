<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\CentroCivicoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TiposActividadController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(TiposActividadController::class)->group(function() {
    Route::get('categorias', 'index'); 
});

Route::middleware('auth:api')->group(function () {
    Route::get('/actividades', [ActividadController::class, 'index']);
    

    Route::post('/actividades/crear', [ActividadController::class, 'store']);
    Route::put('/actividades/{id}', [ActividadController::class, 'update']);
    Route::delete('/actividades/{id}', [ActividadController::class, 'destroy']);
});

Route::get('/actividad/{id}', [ActividadController::class, 'show']);


