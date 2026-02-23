<?php

use App\Http\Controllers\ContactoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Root: redirect to default locale
Route::get('/', function () {
    $locale = session('locale', config('app.locale'));

    return redirect("/{$locale}");
});

// Localized routes
foreach (['es', 'en', 'fr'] as $locale) {
    $t = fn (string $key): string => __("routes.{$key}", [], $locale);

    Route::prefix($locale)
        ->middleware('setLocale')
        ->group(function () use ($locale, $t) {
            // Public
            Route::get('/', HomeController::class)->name("{$locale}.home");
            Route::get($t('courses'), [CursoController::class, 'index'])->name("{$locale}.cursos.index");
            Route::get($t('courses') . '/{curso:slug}', [CursoController::class, 'show'])->name("{$locale}.cursos.show");
            Route::get($t('contact'), fn () => view('pages.contacto'))->name("{$locale}.contacto");
            Route::post($t('contact'), [ContactoController::class, 'send'])->name("{$locale}.contacto.send");
            Route::get($t('privacy'), fn () => view('pages.privacidad'))->name("{$locale}.privacidad");
            Route::get($t('terms'), fn () => view('pages.terminos'))->name("{$locale}.terminos");
            Route::get($t('cookies'), fn () => view('pages.cookies'))->name("{$locale}.cookies");

            // Authenticated
            Route::middleware(['auth', 'verified'])->group(function () use ($locale, $t) {
                Route::get($t('dashboard'), [DashboardController::class, 'index'])->name("{$locale}.dashboard");
                Route::get($t('profile'), [ProfileController::class, 'edit'])->name("{$locale}.profile.edit");
                Route::patch($t('profile'), [ProfileController::class, 'update'])->name("{$locale}.profile.update");
                Route::delete($t('profile'), [ProfileController::class, 'destroy'])->name("{$locale}.profile.destroy");
            });
        });
}

// Fallback redirect for auth controllers that reference route('dashboard')
Route::get('/dashboard', function () {
    return redirect(lroute('dashboard'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth routes (no locale prefix — required by Laravel internals)
require __DIR__ . '/auth.php';
