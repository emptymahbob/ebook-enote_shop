<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public routes
Route::get('/', [BookController::class, 'index'])->name('home');
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // User routes
    Route::get('/my-books', [UserController::class, 'books'])->name('user.books');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    
    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/books/{book}/purchase', [BookController::class, 'purchase'])->name('books.purchase');
    
    // Admin routes
    Route::middleware('admin')->group(function () {
        // Specific routes first
        Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
        Route::post('/books', [BookController::class, 'store'])->name('books.store');
        
        // Parameterized routes last
        Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    });
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index');
    Route::post('/admin/orders/{order}/approve', [App\Http\Controllers\Admin\OrderController::class, 'approve'])->name('admin.orders.approve');
    Route::post('/admin/orders/{order}/reject', [App\Http\Controllers\Admin\OrderController::class, 'reject'])->name('admin.orders.reject');
});

// Parameterized routes last
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// Public book creation routes
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
//     Route::post('/books', [BookController::class, 'store'])->name('books.store');
//     Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
//     Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
//     Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
// });
