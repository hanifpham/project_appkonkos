<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\KosanController;
use App\Http\Controllers\KontrakanController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingDetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\FirebaseAuthController;


/*
|--------------------------------------------------------------------------
| LOGIN & REGISTER
|--------------------------------------------------------------------------
*/

// halaman utama
Route::get('/', HomeController::class)->name('home');
Route::get('/kosan/{kosan}', [ListingDetailController::class, 'kosan'])->name('kosan.detail');
Route::get('/kontrakan/{kontrakan}', [ListingDetailController::class, 'kontrakan'])->name('kontrakan.detail');
Route::post('/contact-messages', [ContactMessageController::class, 'store'])->name('contact-messages.store');


// ==== USER AUTH ====
Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'registerForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/auth/firebase/login', [FirebaseAuthController::class, 'login'])->name('auth.firebase.login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==== ADMIN AUTH ====
Route::get('/admin/auth/login', [AuthController::class, 'adminLoginForm'])->name('admin.login.form');
Route::post('/admin/auth/login', [AuthController::class, 'adminLogin'])->name('admin.login');
Route::post('/admin/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD (role:admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['IsAdmin'])->group(function () {

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::prefix('admin/messages')->name('admin.messages.')->group(function () {
        Route::get('/', [ContactMessageController::class, 'index'])->name('index');
        Route::get('/{message}', [ContactMessageController::class, 'show'])->name('show');
        Route::delete('/{message}', [ContactMessageController::class, 'destroy'])->name('destroy');
    });

    // === Kosan ===
    Route::prefix('admin/kosan')->name('admin.kosan.')->group(function () {
        Route::get('/', [KosanController::class, 'index'])->name('index');
        Route::get('/create', [KosanController::class, 'create'])->name('create');
        Route::post('/store', [KosanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KosanController::class, 'edit'])->name('edit');
        Route::get('/{id}/show', [KosanController::class, 'show'])->name('show');
        Route::put('/{id}', [KosanController::class, 'update'])->name('update');
        Route::delete('/{id}', [KosanController::class, 'destroy'])->name('destroy');
        Route::get('/pdf', [KosanController::class, 'pdf'])->name('pdf');
    });

    // === Kontrakan ===
    Route::prefix('admin/kontrakan')->name('admin.kontrakan.')->group(function () {
        Route::get('/', [KontrakanController::class, 'index'])->name('index');
        Route::get('/create', [KontrakanController::class, 'create'])->name('create');
        Route::post('/store', [KontrakanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KontrakanController::class, 'edit'])->name('edit');
        Route::get('/{id}/show', [KontrakanController::class, 'show'])->name('show');
        Route::put('/{id}', [KontrakanController::class, 'update'])->name('update');
        Route::delete('/{id}', [KontrakanController::class, 'destroy'])->name('destroy');
        Route::get('/pdf', [KontrakanController::class, 'pdf'])->name('pdf');
    });

    // === Booking ===
    Route::prefix('admin/booking')->name('admin.booking.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::get('/{id}', [BookingController::class, 'show'])->name('show');
        Route::post('/{id}/status', [BookingController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{id}', [BookingController::class, 'destroy'])->name('destroy');
    });


    // === User Management ===
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::get('/{id}/show', [UserController::class, 'show'])->name('show');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| USER DASHBOARD (role:user)
|--------------------------------------------------------------------------
*/

Route::middleware(['IsLogin'])->group(function () {
    Route::get('/home', fn() => view('user.home.index'))->name('user.home.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::get('/booking/kosan/{kosan}', [BookingController::class, 'createForKosan'])->name('booking.create.kosan');
    Route::get('/booking/kontrakan/{kontrakan}', [BookingController::class, 'createForKontrakan'])->name('booking.create.kontrakan');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
});
