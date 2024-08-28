<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Middleware\CustomerMiddleware;
use App\Http\Middleware\MerchantMiddleware;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CateringSearchController;
use App\Http\Controllers\MerchantProfileController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rute untuk Merchant
Route::middleware(['auth', MerchantMiddleware::class])->group(function () {
    Route::get('/merchant/profile/edit', [MerchantProfileController::class, 'edit'])->name('merchant.profile.edit');
    Route::put('/merchant/profile/update', [MerchantProfileController::class, 'update'])->name('merchant.profile.update');
    Route::resource('merchant/menu', MenuController::class)
        ->except(['show', 'update', 'destroy', 'edit'])
        ->names([
            'index' => 'merchant.menu.index',
            'create' => 'merchant.menu.create',
            'store' => 'merchant.menu.store',
        ]);
    Route::get('/merchant/menu/{id}/edit', [MenuController::class, 'edit'])->name('merchant.menu.edit');
    Route::put('/merchant/menu/{id}', [MenuController::class, 'update'])->name('merchant.menu.update');
    Route::delete('/merchant/menu/{id}', [MenuController::class, 'destroy'])->name('merchant.menu.destroy');

    Route::get('/merchant/orders', [OrderController::class, 'index'])->name('merchant.orders.index');
});

// Rute untuk Customer
Route::middleware(['auth', CustomerMiddleware::class])->group(function () {
    Route::get('/catering/search', [CateringSearchController::class, 'index'])->name('catering.search');
    // Place Order
    
Route::get('/orders/create', [CustomerOrderController::class, 'create'])->name('customer.orders.create');
Route::post('/orders/store', [CustomerOrderController::class, 'store'])->name('customer.orders.store');

    // View Invoices
    Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('customer.invoices.show');
});
