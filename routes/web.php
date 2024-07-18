<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionsController;
use App\Models\Products;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


require __DIR__ . '/auth.php';

Route::get('/not-found', function () {
    return view('error.404');
})->name('404');



Route::middleware(['auth', 'userMiddleware'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::prefix('/user')->group(function () {

        Route::get('/setting', [ProfileController::class, 'edit'])->name('user_settings');
        Route::post('/update', [ProfileController::class, 'update'])->name('update_user');
        // Route::get('/{transaction_id}', [TransactionsController::class, 'show'])->name('show_transaction');
        // Route::post('/store', [TransactionsController::class, 'store'])->name('store_transactions');
    });

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Order Histroy
    Route::prefix('/transaction')->group(function () {

        Route::get('/', [TransactionsController::class, 'index'])->name('transaction_history');
        Route::get('/{transaction_id}', [TransactionsController::class, 'show'])->name('show_transaction');
        Route::post('/store', [TransactionsController::class, 'store'])->name('store_transactions');
    });

    // Cart
    Route::prefix('/cart')->group(function () {
        Route::post('/add', [CartController::class, 'addToCart'])->name('add_cart');
        Route::get('/show', [CartController::class, 'showCart'])->name('show_cart');
        Route::post('/update', [CartController::class, 'updateCart'])->name('update_cart');
        Route::post('/destroy', [CartController::class, 'destroyCart'])->name('destroy_cart');
    });


    // Products
    Route::prefix('/products')->group(function () {
        Route::get('/filter', [ProductsController::class, 'filtering_product'])->name('filter_products');
        Route::get('/', [ProductsController::class, 'index'])->name('show_products');
        Route::get('/{slug}', [ProductsController::class, 'show'])->name('product_detail');
    });
});






Route::middleware(['auth', 'adminMiddleware'])->group(function () {

    Route::prefix('/order')->group(function () {
        Route::get('/', [OrderController::class,  'index'])->name('index_order');
        // Route::get('/detail', [OrderController::class,  'index'])->name('index_order');
    });

    Route::prefix('/product')->group(function () {
        Route::post('/update', [ProductsController::class, 'update'])->name('update_product');
        Route::get('/create', [ProductsController::class, 'create'])->name('create_product');
        Route::post('/store', [ProductsController::class, 'store'])->name('store_product');
        Route::get('/show', [ProductsController::class, 'show_products_admin'])->name('show_product_admin');
        Route::get('/edit/{slug}', [ProductsController::class, 'edit'])->name('edit_product');
        Route::post('/delete', [ProductsController::class, 'destroy'])->name('delete_product');
    });
});
