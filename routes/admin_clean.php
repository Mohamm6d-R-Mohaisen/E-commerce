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

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application.
| Routes are organized by functionality for better maintainability.
|
*/

// ========================================================================
// ADMIN AUTHENTICATION ROUTES (Public - No Middleware Required)
// ========================================================================

Route::prefix('admin')->name('admin.')->group(function () {
    // Login Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('show-login');
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// ========================================================================
// ADMIN PROTECTED ROUTES (Authentication Required)
// ========================================================================

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['admin']
], function () {

    // ====================================================================
    // DASHBOARD ROUTES
    // ====================================================================
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // ====================================================================
    // CATALOG MANAGEMENT ROUTES
    // ====================================================================
    
    // Categories Management
    Route::resource('categories', CategoriesController::class);
    
    // Products Management
    Route::resource('products', ProductController::class);
    
    // ====================================================================
    // WEBSITE CONTENT MANAGEMENT ROUTES  
    // ====================================================================
    
    // Sliders Management
    Route::resource('sliders', SliderController::class);
    Route::patch('sliders/{slider}/toggle-status', [SliderController::class, 'toggleStatus'])->name('sliders.toggle-status');
    Route::post('sliders/update-sort-order', [SliderController::class, 'updateSortOrder'])->name('sliders.update-sort-order');
    
    // Banners Management
    Route::resource('banners', BannerController::class);
    Route::patch('banners/{banner}/toggle-status', [BannerController::class, 'toggleStatus'])->name('banners.toggle-status');
    Route::get('banners/by-type', [BannerController::class, 'getByType'])->name('banners.by-type');
    Route::post('banners/update-sort-order', [BannerController::class, 'updateSortOrder'])->name('banners.update-sort-order');
    
    // Brands Management
    Route::resource('brands', BrandController::class);
    Route::patch('brands/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])->name('brands.toggle-status');
    Route::get('brands/get-brands', [BrandController::class, 'getBrands'])->name('brands.get-brands');
    Route::post('brands/update-sort-order', [BrandController::class, 'updateSortOrder'])->name('brands.update-sort-order');
    
    // ====================================================================
    // PROMOTIONS & OFFERS MANAGEMENT ROUTES
    // ====================================================================
    
    // Special Offers Management
    Route::resource('special-offers', SpecialOfferController::class);
    Route::patch('special-offers/{specialOffer}/toggle-status', [SpecialOfferController::class, 'toggleStatus'])->name('special-offers.toggle-status');
    Route::get('special-offers/current', [SpecialOfferController::class, 'getCurrentOffers'])->name('special-offers.current');
    Route::post('special-offers/update-sort-order', [SpecialOfferController::class, 'updateSortOrder'])->name('special-offers.update-sort-order');
    Route::patch('special-offers/{specialOffer}/extend', [SpecialOfferController::class, 'extendOffer'])->name('special-offers.extend');
    Route::post('special-offers/{specialOffer}/duplicate', [SpecialOfferController::class, 'duplicate'])->name('special-offers.duplicate');
    
    // ====================================================================
    // ORDER MANAGEMENT ROUTES
    // ====================================================================
    
    Route::controller(OrderController::class)->prefix('orders')->name('orders.')->group(function () {
        // Order Export
        Route::get('export', 'export')->name('export');
        
        // Order CRUD (limited to index, show, destroy)
        Route::get('/', 'index')->name('index');
        Route::get('/{order}', 'show')->name('show');
        Route::delete('/{order}', 'destroy')->name('destroy');
        
        // Order Status Management
        Route::patch('/{order}/update-status', 'updateStatus')->name('update-status');
        Route::patch('/{order}/update-payment-status', 'updatePaymentStatus')->name('update-payment-status');
    });
    
    // Blogs Management Routes
    Route::prefix('blogs')->name('blogs.')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('/create', [BlogController::class, 'create'])->name('create');
        Route::post('/', [BlogController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BlogController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BlogController::class, 'update'])->name('update');
        Route::delete('/{id}', [BlogController::class, 'destroy'])->name('destroy');
    });
    
    // ====================================================================
    // CONTENT PAGES MANAGEMENT ROUTES
    // ====================================================================
    
    // About Management
    Route::resource('about', AboutController::class);
    
    // Team Management 
    Route::resource('team', TeamController::class);
    
}); 