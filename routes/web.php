<?php

use App\Http\Controllers\BranchesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


Route::get('/home', [HomeController::class, 'index']);

Route::resource('/invoices', InvoicesController::class);

Route::resource('/branches', BranchesController::class);

Route::resource('/products', ProductController::class);

Route::get('/get-products/{branch_id}', [ProductController::class, 'getProducts']);




Route::get('test', function () {
    return view('aLL.modals');
});