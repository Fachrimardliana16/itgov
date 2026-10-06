<?php

use App\Http\Controllers\BudgetPlannerController;
use App\Http\Controllers\CredentialVaultController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SopController;
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
    Route::resource('vault', CredentialVaultController::class)->except(['show']);
    Route::post('/vault/{credential}/reveal', [CredentialVaultController::class, 'reveal'])->name('vault.reveal');
});

/*
|--------------------------------------------------------------------------
| Module 3: IT Budget Planner
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Summary HARUS sebelum resource — 'summary' akan dicocokkan ke {budget} kalau resource duluan
    Route::get('/budget/summary', [BudgetPlannerController::class, 'summary'])->name('budget.summary');
    Route::resource('budget', BudgetPlannerController::class);
});