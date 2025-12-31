<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AddOnsController;
use App\Http\Controllers\CategoryController;



Route::resource('product', ProductController::class);
    Route::resource('addons', AddOnsController::class);
    Route::resource('categories', CategoryController::class);



Route::get("/index", [DashboardController::class,"index"])->name("home");
Route::get("/order/details/{id}", [CartController::class,"OrderDetails"])->name("orderdetails");
Route::get("/success", [CartController::class,"success"])->name("success");
Route::get("/checkout", [CartController::class,"checkout"])->name("checkout");
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');

Route::get('/clear-cart', function () {
    session()->forget('cart');
    return 'Cart cleared';
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
