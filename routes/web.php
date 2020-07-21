<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::get('activate/{token}', function($token) {
    return 'activate page with token ' . $token;
})->name('activate');
Route::post('register', 'Register')->name('register');
