<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
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

// Single login page (auto-redirect by role)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.post');

// Standard registration
Route::get('/register', [AuthController::class, 'registerUser'])->name('register');
Route::post('/register', [AuthController::class, 'handleRegister'])->name('register.post');

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
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'googleCallback'])->name('auth.google.callback');


/*
|--------------------------------------------------------------------------
| MEMBERSHIP ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/membership', [MembershipController::class, 'landingPage'])->name('membership.landing');
Route::get('/membership/register', [MembershipController::class, 'showRegistration'])->name('membership.register');
Route::post('/membership/register', [MembershipController::class, 'register'])->name('membership.register.post');
Route::get('/membership/payment', [MembershipController::class, 'showPayment'])->middleware('auth')->name('membership.payment');
Route::post('/membership/payment', [MembershipController::class, 'createPayment'])->middleware('auth')->name('membership.payment.create');
Route::post('/membership/notification', [MembershipController::class, 'paymentNotification'])->name('membership.notification');
Route::get('/membership/success', [MembershipController::class, 'paymentSuccess'])->middleware('auth')->name('membership.success');


/*
|--------------------------------------------------------------------------
| PUBLIC MENU & PRODUCTS
|--------------------------------------------------------------------------
*/
Route::get('/menu', [HomepageController::class, 'product'])->name('menu');
Route::get('/product', [HomepageController::class, 'product'])->name('product');
Route::get('/product/{barang}', [HomepageController::class, 'detailProduct'])->name('product.detail');


/*
|--------------------------------------------------------------------------
| PUBLIC/GUEST BOOKING
|--------------------------------------------------------------------------
*/
// halaman form utama book a table
Route::get('/book', [BookingController::class, 'create'])->name('book');
Route::post('/book', [BookingController::class, 'store'])->name('book.store');
Route::get('/book/confirmed/{booking}', [BookingController::class, 'confirmed'])->name('book.confirmed');


/*
|--------------------------------------------------------------------------
| PAYMENT ROUTES (Midtrans Callback)
|--------------------------------------------------------------------------
*/
Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');
Route::post('/membership/payment/notification', [MembershipController::class, 'paymentNotification'])->name('membership.payment.notification');
Route::get('/payment/webhook-url', [PaymentController::class, 'getWebhookUrl'])->name('payment.webhook-url');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/pending', [PaymentController::class, 'pending'])->name('payment.pending');
Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');


/*
|--------------------------------------------------------------------------
| USER AREA (HARUS LOGIN, ROLE: USER)
|--------------------------------------------------------------------------
*/
Route::prefix('/user')->middleware(['auth', 'role:user|admin'])->group(function () {
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('user.cart.index');
    Route::post('/cart/add/{barang}', [CartController::class, 'add'])->name('user.cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('user.cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('user.cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('user.cart.clear');
    
    // Checkout
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('user.checkout');
    
    // My Bookings
    Route::get('/bookings', [BookingController::class, 'myBookings'])->name('user.bookings');
    Route::delete('/bookings/{booking}', [BookingController::class, 'cancel'])->name('user.bookings.cancel');
    
    // My Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('user.orders');
    Route::post('/orders', [OrderController::class, 'store'])->name('user.orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('user.orders.show');
});

/*
|--------------------------------------------------------------------------
| USER DASHBOARD (Member Area)
|--------------------------------------------------------------------------
*/
Route::prefix('/dashboard')->name('user.dashboard')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\UserDashboardController::class, 'index']);
    Route::get('/membership', [App\Http\Controllers\MembershipController::class, 'dashboard'])->name('.membership');
    Route::post('/membership/activate', [App\Http\Controllers\MembershipController::class, 'activate'])->name('.membership.activate');
    Route::post('/membership/confirm', [App\Http\Controllers\MembershipController::class, 'confirmPayment'])->name('.membership.confirm');
    Route::post('/membership/cancel', [App\Http\Controllers\MembershipController::class, 'cancelMembership'])->name('.membership.cancel');
    Route::get('/orders', [App\Http\Controllers\UserDashboardController::class, 'orders'])->name('.orders');
    Route::post('/orders', [App\Http\Controllers\UserDashboardController::class, 'storeOrder'])->name('.orders.store');
    Route::get('/bookings', [App\Http\Controllers\UserDashboardController::class, 'bookings'])->name('.bookings');
    Route::post('/bookings', [App\Http\Controllers\UserDashboardController::class, 'storeBooking'])->name('.bookings.store');
    Route::post('/bookings/{id}/cancel', [App\Http\Controllers\UserDashboardController::class, 'cancelBooking'])->name('.bookings.cancel');
    Route::get('/points', [App\Http\Controllers\UserDashboardController::class, 'points'])->name('.points');
    Route::get('/profile', [App\Http\Controllers\UserDashboardController::class, 'profile'])->name('.profile');
    Route::put('/profile', [App\Http\Controllers\UserDashboardController::class, 'updateProfile'])->name('.profile.update');
});


/*
|--------------------------------------------------------------------------
| ADMIN AREA (HARUS LOGIN + ROLE ADMIN)
|--------------------------------------------------------------------------
*/
Route::prefix('/admin')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/analytics/data', [AdminController::class, 'getAnalyticsData'])->name('admin.analytics.data');

    // USER MANAGEMENT
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users.index');
    Route::get('/getUser', [UserController::class, 'getUser'])->name('user.get');
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/create', [UserController::class, 'handleCreate'])->name('user.store');
    Route::get('/user/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/edit/{user}', [UserController::class, 'handleEdit'])->name('user.update');
    Route::delete('/user/delete/{user}', [UserController::class, 'delete'])->name('user.delete');

    // PRODUCT/BARANG MANAGEMENT
    Route::get('/getBarang', [BarangController::class, 'getBarang'])->name('barang.get');
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang/create', [BarangController::class, 'handleCreate'])->name('barang.store');
    Route::get('/barang/edit/{barang}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::post('/barang/edit/{barang}', [BarangController::class, 'handleEdit'])->name('barang.update');
    Route::delete('/barang/delete/{barang}', [BarangController::class, 'delete'])->name('barang.delete');

    // ORDER MANAGEMENT
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'adminShow'])->name('admin.orders.show');
    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');

    // BOOKING MANAGEMENT
    Route::get('/bookings', [BookingController::class, 'index'])->name('admin.bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'adminCreate'])->name('admin.bookings.create');
    Route::post('/bookings', [BookingController::class, 'adminStore'])->name('admin.bookings.store');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'adminEdit'])->name('admin.bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'adminUpdate'])->name('admin.bookings.update');
    Route::post('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('admin.bookings.update-status');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('admin.bookings.delete');

    // VOUCHER MANAGEMENT
    Route::get('/vouchers', [VoucherController::class, 'index'])->name('admin.vouchers.index');
    Route::get('/vouchers/create', [VoucherController::class, 'create'])->name('admin.vouchers.create');
    Route::post('/vouchers', [VoucherController::class, 'store'])->name('admin.vouchers.store');
    Route::get('/vouchers/{voucher}/edit', [VoucherController::class, 'edit'])->name('admin.vouchers.edit');
    Route::put('/vouchers/{voucher}', [VoucherController::class, 'update'])->name('admin.vouchers.update');
    Route::delete('/vouchers/{voucher}', [VoucherController::class, 'destroy'])->name('admin.vouchers.delete');

    // POS SYSTEM
    Route::get('/pos', [POSController::class, 'index'])->name('admin.pos.index');
    Route::post('/pos/transaction', [POSController::class, 'createTransaction'])->name('admin.pos.transaction');
    Route::get('/pos/receipt/{order}', [POSController::class, 'receipt'])->name('admin.pos.receipt');
    Route::get('/pos/transactions', [POSController::class, 'transactions'])->name('admin.pos.transactions');

});

// API Routes for voucher validation
Route::post('/api/voucher/validate', [VoucherController::class, 'validateVoucher'])->middleware('auth')->name('api.voucher.validate');
