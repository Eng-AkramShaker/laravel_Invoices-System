<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;






Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


Route::get('/home', [AdminController::class, 'index'])->name('home');