<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\ProductManagement;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\OrderManagement;
use App\Livewire\Admin\CustomerManagement;
use App\Livewire\Admin\ShippingSettings;
use App\Livewire\Admin\StoreSettings;
use App\Livewire\Admin\FinancialReports;
use App\Livewire\Admin\HelpCenter;
use App\Livewire\User\Homepage;
use App\Livewire\User\ProductList;
use App\Livewire\User\ProductDetail;
use App\Http\Controllers\ProfileCompletionController;
use App\Livewire\User\Cart;
use App\Livewire\User\Coupon;
use App\Livewire\User\Checkout;
use App\Livewire\User\Payment;
use App\Livewire\User\PaymentSuccess;
use App\Livewire\User\PaymentMethods;
use App\Livewire\User\Activities;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ============================================================================
// PUBLIC ROUTES (No authentication required - Guest can browse)
// ============================================================================

// Homepage - User Landing Page
Route::get('/', Homepage::class)->name('home');

// Product List - Public browsing (thumbnail, nama, harga SAJA)
Route::get('/products', ProductList::class)->name('products');

// Category Filter - Public
Route::get('/category/{slug}', function ($slug) {
    return app(ProductList::class)->filterByCategory($slug);
})->name('products.category');

// Search Products - Public
Route::get('/search', function () {
    return app(ProductList::class);
})->name('products.search');

// Location Routes
Route::get('/location-prompt', function () {
    return view('location');
})->name('location.show');

Route::get('/location/search', function () {
    return view('location-search');
})->name('location.search');


// ============================================================================
// AUTHENTICATED ROUTES (Requires login to access)
// ============================================================================

Route::middleware(['auth'])->group(function () {

    // ========================================================================
    // USER - PRODUCT INTERACTION (Must login)
    // ========================================================================

    // Product Detail - REQUIRES LOGIN ✅
    Route::get('/products/{slug}', ProductDetail::class)->name('products.show');

    // Cart Routes - REQUIRES LOGIN ✅
    Route::get('/cart', Cart::class)->name('cart');

    // Coupon
    Route::get('/coupons', Coupon::class)->name('coupons');

    // Checkout - REQUIRES LOGIN ✅
    Route::get('/checkout', Checkout::class)->name('checkout');

    // Payment Method
    Route::get('/pembayaran', PaymentMethods::class)->name('payments');

    // User Dashboard & Activities
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    Route::get('/activities', Activities::class)->name('activities');

    Route::get('/orders', function () {
        return view('coming-soon', ['title' => 'Pesanan Saya']);
    })->name('orders');

    Route::get('/wishlist', function () {
        return view('coming-soon', ['title' => 'Wishlist']);
    })->name('wishlist');

    Route::get('/payment/{orderId}', Payment::class)->name('payment');

    Route::get('/payment/{orderId}/success', PaymentSuccess::class)->name('payment.success');

    // Inbox/Messages
    Route::get('/inbox', function () {
        return view('coming-soon', ['title' => 'Kotak Masuk']);
    })->name('inbox');

    // User Account
    Route::get('/account', function () {
        return view('coming-soon', ['title' => 'Akun Saya']);
    })->name('account');


    // ========================================================================
    // PROFILE COMPLETION (After Registration)
    // ========================================================================
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/complete', [ProfileCompletionController::class, 'create'])
            ->name('complete');

        Route::post('/complete', [ProfileCompletionController::class, 'store'])
            ->name('store');
    });


    // ========================================================================
    // ADMIN ROUTES (Only accessible by admin users)
    // ========================================================================
    Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', Dashboard::class)->name('dashboard');

        // Manajemen Produk
        Route::get('/products', ProductManagement::class)->name('products.index');

        // Manajemen Pesanan
        Route::get('/orders', OrderManagement::class)->name('orders.index');

        // Manajemen Pelanggan
        Route::get('/customers', CustomerManagement::class)->name('customers.index');

        // Pengaturan Pengiriman
        Route::get('/shipping-settings', ShippingSettings::class)->name('shipping.settings');

        // Pengaturan Toko
        Route::get('/store-settings', StoreSettings::class)->name('store.settings');

        // Keuangan & Laporan
        Route::get('/financial-reports', FinancialReports::class)->name('financial.reports');

        // Pusat Bantuan
        Route::get('/help-center', HelpCenter::class)->name('help.center');
    });
});


// ============================================================================
// AUTHENTICATION ROUTES (Provided by Laravel Breeze)
// ============================================================================
require __DIR__ . '/auth.php';
