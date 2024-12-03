<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('user');
Route::view('customers', 'customers');
Route::view('loainguyenlieu', 'loainguyenlieu');
Route::view('loaidouong', 'loaidouong');
Route::view('nguyenlieu', 'nguyenlieu');
Route::view('douong', 'douong');
Route::view('baiviet', 'baiviet');
Route::get('/email/verify', [App\Http\Controllers\Auth\ResetController::class, 'verify_email'])->name('verify')->middleware('fireauth');
Route::post('login/{provider}/callback', 'Auth\LoginController@handleCallback');