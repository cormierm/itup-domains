<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('edit', 'Edit')->name('edit');
Route::post('update', 'Update')->name('update');
Route::get('activate/{token}', 'Activate')->name('activate');
Route::post('check', 'Check')->name('check');
Route::post('register', 'Register')->name('register');
