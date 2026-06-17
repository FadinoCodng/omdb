<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\App;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/lang/{locale}', function ($locale) {

    if (!in_array($locale, ['en', 'id'])) {
        abort(400);
    }

    session(['locale' => $locale]);

    App::setLocale($locale);

    return redirect()->back();

})->name('lang.switch');

// Auth (hanya bisa diakses jika BELUM login)
Route::middleware('guest.custom')->group(function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'register_process'])->name('register.process');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'login_process'])->name('login.process');
});

// Halaman yang hanya bisa diakses jika SUDAH login
Route::middleware('checklogin')->group(function () {
    Route::get('/dashboard', [MovieController::class, 'dashboard'])->name('dashboard');

    Route::get('/search', [MovieController::class, 'searchPage'])->name('search');

    Route::get('/favorites', [MovieController::class, 'favorites'])->name('favorites');

    // AJAX API endpoints
    Route::get('/api/movies/search', [MovieController::class, 'search'])->name('api.movies.search');
    Route::get('/api/movies/{imdbId}', [MovieController::class, 'detail'])->name('api.movies.detail');
    Route::post('/favorites/toggle', [MovieController::class, 'toggleFavorite'])->name('favorites.toggle');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});