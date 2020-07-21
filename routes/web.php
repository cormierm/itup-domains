<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::get('activate/{token}', 'Activate')->name('activate');
Route::post('register', 'Register')->name('register');
