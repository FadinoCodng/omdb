<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::get('/favorites', function () {
        return view('favorit.favorites');
    })->name('favorites');

    Route::get('/search', function () {
        return view('search.search');
    })->name('search');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});