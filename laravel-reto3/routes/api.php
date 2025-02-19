<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TiposActividadController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\CentroCivicoController;
use App\Http\Controllers\MonitorController;

use App\Http\Controllers\TestEmailController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth:api'); 
Route::get('/user', [UserController::class, 'user'])->name('user')->middleware('auth:api'); 

Route::controller(TiposActividadController::class)->group(function() {
    Route::get('categorias', 'index');
    Route::get('tipos_actividades', 'index');
    Route::post('tipos_actividades', 'store');
    Route::put('tipos_actividades/{id}', 'update');
});

Route::middleware('auth:api')->group(function () {
    Route::get('/actividades', [ActividadController::class, 'index']);
    Route::post('/actividades', [ActividadController::class, 'store']);
    Route::put('/actividades/{id}', [ActividadController::class, 'update']);
    Route::delete('/actividades/{id}', [ActividadController::class, 'destroy']);
});

Route::controller(TiposActividadController::class)->group(function() {
    Route::get('categorias', 'index');
    Route::get('tipos_actividades', 'index');
    Route::post('tipos_actividades', 'store');
    Route::put('tipos_actividades/{id}', 'update');
});

Route::middleware('auth:api')->group(function () {
    Route::get('/centro_civico', [CentroCivicoController::class, 'index']);
    Route::post('/centro_civico', [CentroCivicoController::class, 'store']);
    Route::put('/centro_civico/{id}', [CentroCivicoController::class, 'update']);
    Route::delete('/centro_civico/{id}', [CentroCivicoController::class, 'destroy']);
});

Route::get('/actividad/{id}', [ActividadController::class, 'show']);

Route::controller(UserController::class)->group(function() {
    Route::post('inscribir', 'inscribir');
});

Route::get('/actividad/{id}', [ActividadController::class, 'show']);
Route::get('/monitores', [MonitorController::class, 'index']);

Route::post('/test-email', [TestEmailController::class, 'sendTestEmail']);