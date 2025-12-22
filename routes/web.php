<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;


Route::resource('product', ProductController::class);



Route::get("/index", [DashboardController::class,"index"])->name("home");
Route::get("/success", [DashboardController::class,"success"])->name("success");
Route::get("/order/details", [DashboardController::class,"OrderDetails"])->name("orderdetails");
Route::get("/checkout", [DashboardController::class,"checkout"])->name("checkout");
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
