<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
});

Route::get('/favorites', function () {
    return view('favorit.favorites');
});

Route::get('/search', function () {
    return view('search.search');
});