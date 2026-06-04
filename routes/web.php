<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

// ── Public ────────────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/katalog/{product:slug}', [CatalogController::class, 'show'])->name('catalog.show');

Route::post('/konsultasi', [LeadController::class, 'store'])
    ->name('konsultasi.store')
    ->middleware('throttle:5,1');

// ── Admin ─────────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login',  [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [Admin\AuthController::class, 'login'])->name('login.post');
    Route::post('logout',[Admin\AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', Admin\ProductController::class);
        Route::patch('products/{product}/featured', [Admin\ProductController::class, 'toggleFeatured'])
            ->name('products.toggle-featured');

        Route::get('leads/export', [Admin\LeadController::class, 'export'])->name('leads.export');
        Route::get('leads', [Admin\LeadController::class, 'index'])->name('leads.index');
        Route::patch('leads/{lead}/status', [Admin\LeadController::class, 'updateStatus'])->name('leads.update-status');

        Route::resource('banners', Admin\BannerController::class);
        Route::resource('testimonials', Admin\TestimonialController::class);
        Route::resource('articles', Admin\ArticleController::class);
    });
});
