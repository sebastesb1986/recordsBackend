<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// 1. Rutas para registro y lectura de clientes
Route::get('clients', [ClientController::class, 'index'])->name('client.index');
Route::get('show-client/{id}', [ClientController::class, 'show'])->name('client.show');
Route::post('create-client', [ClientController::class, 'store'])->name('client.create');
Route::put('update-client/{id}', [ClientController::class, 'update'])->name('client.update');
Route::get('logsClient', [ClientController::class, 'logsClient'])->name('client.logs');
