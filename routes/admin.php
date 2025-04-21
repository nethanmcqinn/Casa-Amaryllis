<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update-status');
    Route::resource('products',ProductController::class)->names('admin.products');
    Route::resource('categories', CategoryController::class)->names('admin.categories');
    Route::post('/profile/update-picture', [UserController::class, 'updateProfilePicture'])->name('admin.profile.update-picture');
    Route::resource('users', UserController::class)->names('admin.users');
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('admin.reviews.index');
    Route::delete('/reviews/{review}', [AdminController::class, 'deleteReview'])->name('admin.reviews.destroy');
    Route::get('/charts', [ChartController::class, 'index'])->name('admin.charts.index');
    Route::post('/products/import', [ProductController::class, 'import'])->name('admin.products.import');

}); 
route::get('products_delete/{id}',[ProductController::class,'products_delete'])->name('products_delete');
route::get('products/restore/{id}',[ProductController::class,'restore'])->name('products.restore');