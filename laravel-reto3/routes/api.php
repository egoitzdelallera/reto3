<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\CentroCivicoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth:api'); 
Route::get('/user', [UserController::class, 'user'])->name('user')->middleware('auth:api'); 

Route::middleware('auth:api')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users/create', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/actividades', [ActividadController::class, 'index']);
    Route::post('/actividades/crear', [ActividadController::class, 'store']);
    Route::put('/actividades/{id}', [ActividadController::class, 'update']);
    Route::delete('/actividades/{id}', [ActividadController::class, 'destroy']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/centro-civico', [CentroCivicoController::class, 'index']);
    Route::post('/centro-civico/crear', [CentroCivicoController::class, 'store']);
    Route::put('/centro-civico/{id}', [CentroCivicoController::class, 'update']);
    Route::delete('/centro-civico/{id}', [CentroCivicoController::class, 'destroy']);
});


