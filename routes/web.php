<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\OrderController;


// Public routes
//Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home'); 

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/signup', [LoginController::class, 'showSignupForm'])->name('signup');
    Route::post('/signup', [LoginController::class, 'signup'])->name('signup.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Profile routes
Route::middleware('auth:web')->group(function () {
    Route::get('/profile/{id}', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'updateProfile'])->name('profile.update'); 
});



// Product routes
Route::get('/products/category/{category_id}', [ProductController::class, 'showProductWithCategory'])->name('products.category');
Route::get('/product-detail/{product_id}', [ProductController::class, 'showProductDetail'])->name('products.detail');
Route::get('/products',[ProductController::class,'allProduct']) ->name('allProduct');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');
Route::post('/removeFromCart', [CartController::class, 'removeFromCart'])->name('removeFromCart');
Route::post('/updateCartQuantity', [CartController::class, 'updateCartQuantity'])->name('updateCartQuantity');
Route::get('/search', [ProductController::class, 'search'])->name('search');

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::get('/checkout/success', function () {
    echo "<h1>Bạn đã đặt hàng thành công.</h1>";
    echo "<p>Đang chuyển hướng về trang chủ...</p>";
    echo "<script>setTimeout(function() { window.location.href = '/vaastore/home'; }, 600);</script>";
})->name('checkout.success');

Route::get('/checkout/failure', function () {
    echo "<h1>Có lỗi xảy ra trong quá trình xử lý đơn hàng.</h1>";
    echo "<p>Đang chuyển hướng về trang chủ...</p>";
    echo "<script>setTimeout(function() { window.location.href = '/vaastore/home'; }, 600);</script>";
})->name('checkout.failure');

Route::post('/vnpay/payment', [PaymentController::class, 'vnpay_payment'])->name('vnpay.payment');
Route::get('paypal', [PayPalController::class, 'index'])->name('paypal');
Route::match(['get', 'post'], 'paypal/payment', [PayPalController::class, 'payment'])->name('paypal.payment');
Route::get('paypal/payment/success', [PayPalController::class, 'paymentSuccess'])->name('paypal.payment.success');
Route::get('paypal/payment/cancel', [PayPalController::class, 'paymentCancel'])->name('paypal.payment/cancel');

// Route hiển thị danh sách yêu thích của người dùng
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
Route::post('/addToFavorites', [ProductController::class, 'addToFavorites'])->name('addToFavorites');

// Route thêm hoặc bỏ yêu thích sản phẩm
Route::post('/products/{product_id}/favorite', [FavoriteController::class, 'toggleFavorite'])->name('products.favorite');


// Admin routes
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/login/admin', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login/admin', [AdminController::class, 'login'])->name('admin.login.post');
Route::get('admin/add-product', [ProductController::class, 'showAddProductForm'])->name('admin.show_add_product');
Route::post('/admin/add-product', [ProductController::class, 'add_product']);
Route::get('/admin/all-product', [ProductController::class, 'all_product'])->name('admin.all_product');
Route::get('admin/edit-product/{product_id}', [ProductController::class, 'edit'])->name('admin.products.edit');
Route::put('admin/update-product/{product_id}', [ProductController::class, 'update'])->name('admin.update_product');
Route::delete('admin/delete-product/{product_id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
 Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');
Route::get('/order/{id}', [OrderController::class, 'show'])->name('admin.order.show');
Route::get('/order/edit/{id}', [OrderController::class, 'edit'])->name('admin.order.edit');
Route::post('/order/update/{id}', [OrderController::class, 'update'])->name('admin.order.update');
Route::get('/order/delete/{id}', [OrderController::class, 'destroy'])->name('admin.order.delete');