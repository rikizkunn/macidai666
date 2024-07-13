<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

Route::middleware(['auth', 'userMiddleware'])->group(function () {
    Route::get('/user', function () {
        dd(Auth::user()->role);
    });
});


Route::middleware(['auth', 'adminMiddleware'])->group(function () {
    Route::get('/admin', function () {
        dd(Auth::user()->role);
    });
});

Route::get('/not-found', function () {
    return view('error.404');
})->name('404');

// Route::prefix('/auth')->group(function () {
//     // Route::get('/login', [Reg::class, 'index']);
//     Route::get('/register', [RegisteredUserController::class, 'create']);
//     Route::get('/logout', [AuthenticatedSessionController::class, 'destroy']);
// });
// Route::get('/register', [RegisteredUserController::class, 'create']);
Route::prefix('/products')->group(function () {
    
    Route::get('/', [ProductsController::class, 'index'])->name('dashboard');
    Route::get('/{slug}', [ProductsController::class, 'show'])->name('product_detail');
    Route::post('/order', [ProductsController::class, 'show_order'])->name('order_product');
    // Route::post('/order/{trx_id}', [ProductsController::class, 'order'])->name('order_product');
    // Route::get('/create', [ProductsController::class, 'order'])->name('product_detail');
    // Route::post('/store', [ProductsController::class, 'order'])->name('product_detail');
    // Route::put('/update/{slug}', [ProductsController::class, 'order'])->name('product_detail');


});

Route::prefix('/cart')->group(function () {
    Route::post('/add', [CartController::class, 'addToCart'])->name('add_cart');
    Route::get('/show', [CartController::class, 'showCart'])->name('show_cart');
    Route::post('/update', [CartController::class, 'updateCart'])->name('update_cart');
    Route::post('/destroy', [CartController::class, 'destroyCart'])->name('destroy_cart');
});
