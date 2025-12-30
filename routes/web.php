<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

// Halaman login
Route::get('/login-admin', [AuthController::class, 'showLoginAdmin']);
Route::post('/login-admin', [AuthController::class, 'loginAdmin']);

Route::get('/register-customer', [AuthController::class, 'showRegisterCustomer']);
Route::post('/register-customer', [AuthController::class, 'registerCustomer']);
Route::get('/login-customer', [AuthController::class, 'showLoginCustomer']);
Route::post('/login-customer', [AuthController::class, 'loginCustomer']);
Route::get('/select-meja', [AuthController::class, 'showSelectMeja'])->name('customer.select-meja');
Route::post('/select-meja', [AuthController::class, 'selectMeja']);

// Forgot Password
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot.password.send');
Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Logout
Route::get('/logout-admin', [AuthController::class, 'logoutAdmin'])->name('logout.admin');
Route::get('/logout-customer', [AuthController::class, 'logoutCustomer'])->name('logout.customer');

Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
Route::post('/customer/keranjang/add', [CustomerController::class, 'addToCart'])->name('customer.keranjang.add');
Route::get('/customer/keranjang', [CustomerController::class, 'showCart'])->name('customer.keranjang');
Route::delete('/customer/keranjang/{id}', [CustomerController::class, 'deleteFromCart'])->name('customer.cart.delete');
Route::put('/customer/keranjang/{id}', [CustomerController::class, 'updateQty'])->name('customer.cart.update-qty');
Route::post('/customer/checkout', [CustomerController::class, 'checkout'])->name('customer.checkout');
Route::get('/customer/order-history', [CustomerController::class, 'orderHistory'])->name('customer.order-history');
Route::get('/customer/order/{order_id}', [CustomerController::class, 'orderDetail'])->name('customer.order-detail');
Route::get('/customer/order/{order_id}/receipt', [CustomerController::class, 'downloadReceipt'])->name('customer.order.receipt');
Route::get('/customer/orders/recent', [CustomerController::class, 'getRecentOrders'])->name('customer.orders.recent');
Route::get('/customer/notifications', [CustomerController::class, 'getNotifications'])->name('customer.notifications.list');
Route::get('/customer/notifications/api', [CustomerController::class, 'getNotificationsAPI'])->name('customer.notifications.api');
Route::post('/customer/notifications/{notification}/read', [CustomerController::class, 'markNotificationAsRead'])->name('customer.notifications.read');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Menu
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
    Route::post('/menu/{id}/activate', [MenuController::class, 'activate'])->name('menu.activate');

    // Category
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    // Meja
    Route::resource('meja', \App\Http\Controllers\MejaController::class);
    Route::post('/meja/{meja}/release', [\App\Http\Controllers\MejaController::class, 'release'])->name('meja.release');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::post('/orders/{order}/confirm-payment', [OrderController::class, 'confirmPayment'])->name('orders.confirm-payment');

    // Laporan
    Route::get('/laporan', [OrderController::class, 'laporan'])->name('laporan.index');
    Route::get('/laporan/harian', [OrderController::class, 'laporanHarian'])->name('laporan.harian');
    Route::get('/laporan/bulanan', [OrderController::class, 'laporanBulanan'])->name('laporan.bulanan');
});
