<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Si;
use App\Http\Controllers\Penpos;


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

// Kalau mau test pakai postman, harus pakai /api di awalnya
// http://localhost:8000/api/
// Route::get('/', function () {
//     return view('visitor.home');
// })->name('index');

// http://localhost:8000/api/destroy
Route::delete('/{scoreId}/destroy', [Penpos\PenposController::class, 'destroy'])
    ->name('destroy');
