<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;


// Public routes
//Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home'); 

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/signup', [LoginController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [LoginController::class, 'signup'])->name('signup.post');

// Profile routes
Route::get('/profile', [ProfileController::class, 'showProfile'])->middleware('auth')->name('profile');
Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->middleware('auth')->name('edit');
Route::post('/profile/edit', [ProfileController::class, 'updateProfile'])->middleware('auth')->name('update');

// Product routes
Route::get('/products/category/{category_id}', [ProductController::class, 'showProductWithCategory'])->name('products.category');
Route::get('/product-detail/{product_id}', [ProductController::class, 'showProductDetail'])->name('products.detail');
Route::get('/products',[ProductController::class,'allProduct']) ->name('allProduct');


// Admin routes
Route::get('/admin', [AdminController::class, 'dashboard']);
Route::get('/login/admin', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login/admin', [AdminController::class, 'login'])->name('admin.login.post');
Route::get('admin/add-product', [ProductController::class, 'showAddProductForm'])->name('admin.show_add_product');
Route::post('/admin/add-product', [ProductController::class, 'add_product']);
Route::get('/admin/all-product', [ProductController::class, 'all_product'])->name('admin.all_product');
Route::get('admin/edit-product/{product_id}', [ProductController::class, 'edit'])->name('admin.products.edit');
Route::put('admin/update-product/{product_id}', [ProductController::class, 'update'])->name('admin.update_product');
Route::delete('admin/delete-product/{product_id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

