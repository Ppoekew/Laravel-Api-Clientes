<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\studentController;
use App\Http\Controllers\Api\clienteController;

//-----------------------//
// Manejo de Estudiantes //
//-----------------------//

// Route::get('/students', function () {
//     return 'Students List';
//     // return response()->json(['message' => 'Hello World!'], 200);
// });	

// Muestra todos los registros de Estudiantes
Route::get('/students', [studentController::class, 'index']);

// Muestra un registro de Estudiante por su ID
Route::get('/students/{id}', [studentController::class, 'show']);

// Crea un nuevo registro de Estudiante
Route::post('/students', [studentController::class, 'store']);

// Actualiza un registro de Estudiante por su ID
Route::put('/students/{id}', [studentController::class, 'update']);

// Actualiza un campo de un registro de Estudiante por su ID
Route::patch('/students/{id}', [studentController::class, 'updatePartial']);

// Elimina un registro de Estudiante por su ID
Route::delete('/students/{id}', [studentController::class, 'destroy']);

//--------------------//
// Manejo de Clientes //
//--------------------//

// Muestra todos los registros de Clientes
Route::get('/clientes', [clienteController::class, 'index']);

// Muestra un registro de Cliente por su ID
Route::get('/clientes/{id}', [clienteController::class, 'show']);

// Crea un nuevo registro de Cliente
Route::post('/clientes', [clienteController::class, 'store']);

// Actualiza un registro de Cliente por su ID
Route::put('/clientes/{id}', [clienteController::class, 'update']);

// Actualiza un campo de un registro de Cliente por su ID
Route::patch('/clientes/{id}', [clienteController::class, 'updatePartial']);

// Elimina un registro de Cliente por su ID
Route::delete('/clientes/{id}', [clienteController::class, 'destroy']);