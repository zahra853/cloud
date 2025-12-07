<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Homepage (Public)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/location', [HomepageController::class, 'location'])->name('location');
Route::get('/review', [HomepageController::class, 'review'])->name('review');


/*
|--------------------------------------------------------------------------
| AUTH (PUBLIC)
|--------------------------------------------------------------------------
*/

// pilih login → admin / user
Route::get('/login', [AuthController::class, 'chooseRole'])->name('login');

// login admin & user
Route::get('/login/admin', [AuthController::class, 'loginAdmin'])->name('login.admin');
Route::get('/login/user', [AuthController::class, 'loginUser'])->name('login.user');
Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.post');

// FIX: ketika user buka /register langsung → diarahkan ke register/user
Route::get('/register', function () {
    return redirect()->route('register.user');
});

// register admin & user
Route::get('/register/admin', [AuthController::class, 'registerAdmin'])->name('register.admin');
Route::get('/register/user', [AuthController::class, 'registerUser'])->name('register.user');
Route::post('/register', [AuthController::class, 'handleRegister'])->name('register.post');

// ==== FORGOT PASSWORD FLOW ====
// 1. Halaman input email (Forgot Password awal)
Route::get('/password/forgot', function () {
    return view('auth.forgot-password'); // resources/views/auth/forgot-password.blade.php
})->name('password.request');

// 2. Halaman Verify OTP
Route::get('/password/otp', function () {
    return view('auth.verify-otp'); // resources/views/auth/verify-otp.blade.php
})->name('password.otp.form');

// 3. Halaman Reset Password
Route::get('/password/reset', function () {
    return view('auth.reset-password'); // resources/views/auth/reset-password.blade.php
})->name('password.reset.form');

// (opsional: kalau mau beneran jalan backend-nya, ini POST-nya)
Route::post('/password/forgot', [AuthController::class, 'sendResetOtp'])->name('password.email');
Route::post('/password/otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/password/reset', [AuthController::class, 'updatePassword'])->name('password.update');

// logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| USER AREA (HARUS LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/product', [HomepageController::class, 'product'])->name('product');
    Route::get('/product/{barang}', [HomepageController::class, 'detailProduct'])->name('product.detail');
});


/*
|--------------------------------------------------------------------------
| ADMIN AREA (HARUS LOGIN + ROLE ADMIN)
|--------------------------------------------------------------------------
*/
Route::prefix('/admin')->middleware(['auth', 'role:admin'])->group(function () {

    // USER
    Route::get('/getUser', [UserController::class, 'getUser'])->name('user.get');
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/create', [UserController::class, 'handleCreate'])->name('user.store');
    Route::get('/user/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/edit/{user}', [UserController::class, 'handleEdit'])->name('user.update');
    Route::delete('/user/delete/{user}', [UserController::class, 'delete'])->name('user.delete');

    // BARANG
    Route::get('/getBarang', [BarangController::class, 'getBarang'])->name('barang.get');
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang/create', [BarangController::class, 'handleCreate'])->name('barang.store');
    Route::get('/barang/edit/{barang}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::post('/barang/edit/{barang}', [BarangController::class, 'handleEdit'])->name('barang.update');
    Route::delete('/barang/delete/{barang}', [BarangController::class, 'delete'])->name('barang.delete');

});


/*
|--------------------------------------------------------------------------
| PUBLIC MENU & BOOKING
|--------------------------------------------------------------------------
*/
Route::get('/menu', [HomepageController::class, 'product'])->name('menu');

// halaman form utama book a table
Route::get('/book', function () {
    return view('user.book');              // resources/views/user/book.blade.php
})->name('book');

// step 1: Find a Table
Route::get('/book/detail', function () {
    return view('user.book-detail');       // resources/views/user/book-detail.blade.php
})->name('book.detail');

// step 2: Add Your Detail
Route::get('/book/detail/info', function () {
    return view('user.book-detail-step2'); // resources/views/user/book-detail-step2.blade.php
})->name('book.detail.info');

// step 3: Booking Confirmed
Route::get('/book/confirmed', function () {
    return view('user.book-confirmed');    // resources/views/user/book-confirmed.blade.php
})->name('book.confirmed');
