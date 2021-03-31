<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::get('update/{hostname}', 'Update');
Route::get('activate/{token}', 'Activate')->name('activate');
Route::post('check', 'Check')->name('check');
Route::post('register', 'Register')->name('register');
