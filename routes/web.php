<?php

use App\Http\Controllers\PesananController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\UserController ;
use App\Http\Controllers\UserOrderController;

// Authentication Routes
Route::get('/admin', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/admin', [AuthController::class, 'login']);

// Order Routes
Route::get('/cek-orderan', [PesananController::class, 'index'])->name('orders.index');
Route::get('/pesanan/{id_pesanan}', [PesananController::class, 'show'])
     ->name('orders.show');
Route::patch('/pesanan/{id_pesanan}/status', [PesananController::class, 'updateStatus'])
     ->name('orders.update-status');
Route::patch('/pesanan/{id_pesanan}/cancel', [PesananController::class, 'cancel'])
     ->name('orders.cancel');
Route::post('/pesanan/{id_pesanan}/upload-payment', [PesananController::class, 'uploadPayment'])
     ->name('orders.upload-payment');
Route::get('/pesanan/{id_pesanan}/edit', [PesananController::class, 'edit'])
     ->name('orders.edit');
Route::put('/pesanan/{id_pesanan}', [PesananController::class, 'update'])
     ->name('orders.update');
Route::get('/orders/create/{customer}', [PesananController::class, 'create'])->name('orders.create');
Route::post('/daftar-layanan', [PesananController::class, 'store'])->name('orders.store');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('layanan', LayananController::class)->except(['show']); });



    // Update status routes
Route::patch('/orders/{id_pesanan}/pickup', [PesananController::class, 'markAsPickedUp'])
    ->name('orders.pickup');
Route::patch('/orders/{id_pesanan}/deliver', [PesananController::class, 'markAsDelivered'])
    ->name('orders.deliver');

// Customer Routes with prefix
Route::prefix('customers.')->name('customers.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/create', [CustomerController::class, 'create'])->name('create');
    Route::post('/', [CustomerController::class, 'store'])->name('store');
    Route::get('/{id_customer}', [CustomerController::class, 'show'])->name('show');
    Route::get('/{id_customer}/edit', [CustomerController::class, 'edit'])->name('edit');
    Route::put('/{id_customer}', [CustomerController::class, 'update'])->name('update');
    Route::delete('/{id_customer}', [CustomerController::class, 'destroy'])->name('destroy');
    Route::post('/{id_customer}/reset-password', [CustomerController::class, 'resetPassword'])
         ->name('reset-password');
    // Registration routes
    Route::get('/register/form', [CustomerController::class, 'tampilFormPendaftaran'])->name('registration.form');
    Route::post('/register', [CustomerController::class, 'register'])->name('register');
});

// Standalone Customer Routes (from the second file)
Route::get('/pendaftaran', [CustomerController::class, 'tampilFormPendaftaran'])
     ->name('customer.register.form');
Route::post('/pendaftaran', [CustomerController::class, 'register'])
     ->name('customer.register.submit');
Route::get('/cek-anggota', [CustomerController::class, 'index'])
     ->name('Admin.cek_anggota');
Route::get('customers/{id_customer}', [CustomerController::class, 'show'])
    ->name('admin.customers.show');
Route::get('customers/{id_customer}/edit', [CustomerController::class, 'edit'])
     ->name('admin.customers.edit');

// Layanan Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('layanan', LayananController::class);
});
Route::prefix('admin/layanan')->name('admin.layanan.')->group(function () {
    Route::get('/', [LayananController::class, 'index'])->name('index');
    Route::get('/create', [LayananController::class, 'create'])->name('create');
    Route::post('/', [LayananController::class, 'store'])->name('store');
    Route::get('/{id}', [LayananController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [LayananController::class, 'edit'])->name('edit');
    Route::put('/{id}', [LayananController::class, 'update'])->name('update');
    Route::delete('/{id}', [LayananController::class, 'destroy'])->name('destroy');
});

// Miscellaneous Routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/detail-anggota', function () {
    return view('Admin.detail_anggota');
});
Route::get('/login', function () {
    return view('Customer.login');
});






// customer
// Customer Auth Routes
// routes/web.php
Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');
Route::post('/login', [CustomerAuthController::class, 'login'])->name('customer.login.submit');
Route::post('/customer/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

Route::prefix('customer')->group(function () {
    // Registrasi
    Route::get('/register', [CustomerAuthController::class, 'showRegistrationForm'])->name('customer.register');
    Route::post('/register', [CustomerAuthController::class, 'register'])->name('customer.register.submit');
    
    // Halaman sukses registrasi
    Route::get('/registration-success', [CustomerAuthController::class, 'registrationSuccess'])
         ->name('registration.success');
});

// Rute untuk pelanggan
Route::prefix('customer')->name('customer.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    
    // Profil
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    
    // Pesanan
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [UserOrderController::class, 'index'])->name('index');
        Route::get('/create', [UserOrderController::class, 'create'])->name('create');
        Route::post('/', [UserOrderController::class, 'store'])->name('store');
        Route::get('/{id_pesanan}', [UserOrderController::class, 'show'])->name('show');
    });
});

Route::get('/customer/orders/print/{id_pesanan}', [PesananController::class, 'print'])->name('customer.orders.print');