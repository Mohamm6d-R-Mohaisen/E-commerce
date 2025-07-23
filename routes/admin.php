<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SpecialOfferController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ServiceController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('show-login');
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['admin']
], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('categories', CategoriesController::class);
    Route::resource('products', ProductController::class);
    Route::resource('sliders', SliderController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('special-offers', SpecialOfferController::class);
    Route::resource('services', ServiceController::class);
    
    Route::controller(OrderController::class)->prefix('orders')->name('orders.')->group(function () {
        Route::get('export', 'export')->name('export');
        Route::get('/', 'index')->name('index');
        Route::get('/{order}', 'show')->name('show');
        Route::delete('/{order}', 'destroy')->name('destroy');
        Route::patch('/{order}/update-status', 'updateStatus')->name('update-status');
        Route::patch('/{order}/update-payment-status', 'updatePaymentStatus')->name('update-payment-status');
    });
    
    Route::prefix('blogs')->name('blogs.')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('/create', [BlogController::class, 'create'])->name('create');
        Route::post('/', [BlogController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BlogController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BlogController::class, 'update'])->name('update');
        Route::delete('/{id}', [BlogController::class, 'destroy'])->name('destroy');
    });
    
    // About & Team Management
    Route::resource('about', AboutController::class);
    Route::resource('team', TeamController::class);
    
    // Settings Management
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/update', [SettingController::class, 'update'])->name('update');
        Route::get('/initialize', [SettingController::class, 'initializeDefaults'])->name('initialize');
        Route::get('/clear-cache', [SettingController::class, 'clearCache'])->name('clear-cache');
    });
}); 