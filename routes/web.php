<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;

// Public routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);
Route::get('/product-detail', [ProductController::class, 'showProductDetail']);
Route::get('/product-detail', [ProductController::class, 'index']);

// Admin routes
Route::get('/admin', [AdminController::class, 'dashboard']);
Route::get('/login/admin', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login/admin', [AdminController::class, 'login'])->name('admin.login.post');

// Product management routes
Route::get('admin/add-product', [ProductController::class, 'showAddProductForm'])->name('admin.show_add_product');
Route::post('/admin/add-product', [ProductController::class, 'add_product']);
Route::get('/admin/all-product', [ProductController::class, 'all_product'])->name('admin.all_product');

// Product edit routes
Route::get('admin/edit-product/{product_id}', [ProductController::class, 'edit'])->name('admin.products.edit');
Route::put('admin/update-product/{product_id}', [ProductController::class, 'update'])->name('admin.update_product');
Route::delete('admin/delete-product/{product_id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

