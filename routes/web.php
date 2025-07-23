<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\frontend\Auth\LoginController;
use App\Http\Controllers\frontend\Auth\RegisterController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\OrderController;
use App\Http\Controllers\frontend\PaymentGetWay;
use App\Http\Controllers\frontend\Auth\SocialiteController;
/*
|--------------------------------------------------------------------------
| Frontend Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your frontend application.
| Routes are organized by functionality for better maintainability.
|
*/

// ========================================================================
// AUTHENTICATION ROUTES
// ========================================================================

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'create'])->name('register');
Route::post('register', [RegisterController::class, 'store'])->name('register.submit');

Route::get('/verify-otp', [RegisterController::class, 'showVerifyForm'])->name('show.verify-otp');
Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('verify-otp');
Route::post('/resend-otp', [RegisterController::class, 'resendOtp'])->name('resend.otp');



// ========================================================================
// LOCALIZED ROUTES (Multi-language Support)
// ========================================================================

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
], function () {
    
    // HOME ROUTES
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::post('/contact', [HomeController::class, 'storeContact'])->name('contact.store');
    
    // PRODUCT ROUTES  
    Route::get('/products', [HomeController::class, 'products'])->name('products.index');
    Route::get('/product/{product:slug}', [HomeController::class, 'show'])->name('product.show');
    Route::get('/product', [HomeController::class, 'products'])->name('product.index');

    // CART ROUTES
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/', [CartController::class, 'store'])->name('store');
        Route::put('/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/{id}', [CartController::class, 'destroy'])->name('destroy');
        Route::delete('/', [CartController::class, 'clear'])->name('clear');
        Route::get('/items', [CartController::class, 'getCartItems'])->name('items');
    });
    
    // AUTHENTICATED ROUTES
    Route::middleware('auth')->group(function () {
        
        // ORDER ROUTES
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/{orderId}', [OrderController::class, 'show'])->name('show');
            Route::patch('/{orderId}/status', [OrderController::class, 'updateStatus'])->name('updateStatus');
            Route::patch('/{orderId}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        });
        
        // CHECKOUT ROUTES
        Route::get('checkout', [OrderController::class, 'create'])->name('checkout');
        Route::post('checkout', [OrderController::class, 'store'])->name('order.store');
        Route::get('order/success/{orderId}', [OrderController::class, 'success'])->name('order.success');

        // PAYMENT ROUTES
        Route::prefix('orders/{order}')->name('order.payment.')->group(function () {
            Route::get('/pay', [PaymentGetWay::class, 'create'])->name('create');
            Route::post('/stripe/payment-intent', [PaymentGetWay::class, 'createStriPepayment'])->name('stripe.create');
            Route::get('/payment/stripe/callback', [PaymentGetWay::class, 'confirm'])->name('stripe.return');
            Route::get('/payment', function($order) {
                return redirect()->route('order.payment.create', $order, 301);
            });
        });
        
    });
    
});
Route::get('auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('auth.socialite.redirect');
Route::get('auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('auth.socialite.callback');

