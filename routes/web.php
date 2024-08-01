<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
})->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware('auth');
// Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
Route::get('/setting', [App\Http\Controllers\DashboardController::class, 'setting'])->middleware('auth');
Route::post('/setting', [App\Http\Controllers\DashboardController::class, 'setting_add_kategori'])->middleware('auth');
Route::put('/setting/{id}', [App\Http\Controllers\DashboardController::class, 'setting_edit_kategori'])->middleware('auth');
Route::delete('/setting/{id}', [App\Http\Controllers\DashboardController::class, 'setting_delete_kategori'])->middleware('auth');
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/kelola-kas', [App\Http\Controllers\KasController::class, 'index']);
    Route::post('/kelola-kas', [App\Http\Controllers\KasController::class, 'store']);

    Route::get('/riwayat-kas', [App\Http\Controllers\KasController::class, 'riwayat']);
    Route::post('/cetak-laporan', [App\Http\Controllers\KasController::class, 'cetak']);
});
