<?php

use App\Http\Controllers\CredentialVaultController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\RkapPlannerController;
use App\Http\Controllers\SopController;
use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home');
})->name('home');

/*
|--------------------------------------------------------------------------
| Autentikasi Native (tanpa Breeze — native manual)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [HomeController::class, 'showLogin'])->name('login');
    Route::post('/login', [HomeController::class, 'login']);
    Route::get('/register', [HomeController::class, 'showRegister'])->name('register');
    Route::post('/register', [HomeController::class, 'register']);
});

Route::post('/logout', [HomeController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Module 1: IT SOP Documentation
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::resource('sops', SopController::class);
});

/*
|--------------------------------------------------------------------------
| Module 2: Credential Vault
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::resource('vault', CredentialVaultController::class)->except(['show'])->parameters([
        'vault' => 'credential',
    ]);
    Route::post('/vault/{credential}/reveal', [CredentialVaultController::class, 'reveal'])->name('vault.reveal');
});

/*
|--------------------------------------------------------------------------
| Module 3: RKAP Planner (Rencana Kerja & Anggaran)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Summary HARUS sebelum resource
    Route::get('/rkap/summary', [RkapPlannerController::class, 'summary'])->name('rkap.summary');
    Route::resource('rkap', RkapPlannerController::class);
});

/*
|--------------------------------------------------------------------------
| Module 4: Inventaris IT
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::resource('inventaris', InventarisController::class)->parameters(['inventaris' => 'inventaris']);
});

/*
|--------------------------------------------------------------------------
| Module 5: Tools Check-in/out
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::resource('tools', ToolController::class);
    Route::get('/tools/{tool}/pinjam', [ToolController::class, 'pinjam'])->name('tools.pinjam');
    Route::post('/tools/{tool}/pinjam', [ToolController::class, 'storePinjam'])->name('tools.pinjam.store');
    Route::get('/tools/loans/{loan}/kembalikan', [ToolController::class, 'kembalikan'])->name('tools.kembalikan');
    Route::put('/tools/loans/{loan}/kembalikan', [ToolController::class, 'updateKembalikan'])->name('tools.kembalikan.update');
});
