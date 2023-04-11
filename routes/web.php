<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();


Route::domain("{subdomain}.localhost")->group(function () {
    Route::get('/', [App\Http\Controllers\Frontend\ProductController::class, 'index'])->name('products.index');
    Route::get('products', [App\Http\Controllers\Frontend\ProductController::class, 'show'])->name('products.show');
});

Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('homepage');
Route::get('search', [App\Http\Controllers\Frontend\HomeController::class, 'search'])->name('search');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth','prefix' => 'admin', 'as' => 'admin.'], function() {
    Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::post('products/media', [\App\Http\Controllers\Admin\ProductController::class, 'storeMedia'])->name('products.storeMedia');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
});
