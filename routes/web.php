<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;


Route::get('/',[AuthController::class, 'login'])->name('login');
Route::post('post-login',[AuthController::class, 'postLogin'] )->name('post.login');
Route::get('registor', [AuthController::class, 'registor'])->name('registor');
Route::post('post-registor',[AuthController::class, 'postRegistor'])->name('post.registor');
Route::get('logout',[AuthController::class, 'logout'])->name('logout');

Route::get('admin', [AdminController::class, 'index'])->name('admin');

Route::resource('products',ProductsController::class)->middleware('auth');

Route::get('products-data', [ProductsController::class, 'getProducts'])->name('products-data');

Route::get('Orders',[OrderController::class, 'index'])->name('order.index')->middleware('auth');
Route::post('/order.store',[OrderController::class, 'store'])->name('order.store')->middleware('auth');
Route::get('orders-data', [OrderController::class, 'getOrders'])->name('orders-data')->middleware('auth');
Route::resource('orders', OrderController::class)->middleware('auth');

Route::get('SelectProductOrders',[OrderController::class, 'SelectProductOrders'])->name('SelectProductOrders');


Route::resource('category',CategoryController::class);