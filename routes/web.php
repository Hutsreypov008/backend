<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    });
});

// Vue SPA catch-all — serves the built Vue app for root and all unmatched frontend routes
Route::get('/{any?}', function () {
    $vuePath = base_path('../Frontend/dist/index.html');
    if (file_exists($vuePath)) {
        return response()->file($vuePath);
    }
    // Fallback to Vite dev server if Vue app is not built
    return redirect(env('FRONTEND_URL', 'http://localhost:5173'));
})->where('any', '.*');
