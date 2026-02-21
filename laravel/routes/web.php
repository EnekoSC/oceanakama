<?php

use App\Http\Controllers\ContactoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Público
Route::get('/', HomeController::class)->name('home');
Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
Route::get('/cursos/{curso:slug}', [CursoController::class, 'show'])->name('cursos.show');
Route::get('/contacto', fn () => view('pages.contacto'))->name('contacto');
Route::post('/contacto', [ContactoController::class, 'send'])->name('contacto.send');
Route::get('/privacidad', fn () => view('pages.privacidad'))->name('privacidad');
Route::get('/terminos', fn () => view('pages.terminos'))->name('terminos');
Route::get('/cookies', fn () => view('pages.cookies'))->name('cookies');

// Idioma
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// Autenticado
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
