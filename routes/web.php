<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect(Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard'));
    }

    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::get('/users/{id}/profile', [AdminController::class, 'showUserProfile'])->name('user.profile');
        Route::get('/users/{id}/history', [AdminController::class, 'showUserHistory'])->name('user.history');
        Route::post('/emergency/{userId}/{index}/respond', [AdminController::class, 'respondToEmergency'])->name('emergency.respond');
        Route::get('/emergency-history', [AdminController::class, 'emergencyHistory'])->name('emergency.history');
        Route::post('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');

        Route::get('/change-username', [AdminController::class, 'showChangeUsername'])->name('change-username');
        Route::post('/change-username', [AdminController::class, 'changeUsername'])->name('change-username.post');

        Route::get('/change-password', [AdminController::class, 'showChangePassword'])->name('change-password');
        Route::post('/change-password', [AdminController::class, 'changePassword'])->name('change-password.post');

        Route::get('/delete-account', [AdminController::class, 'showDeleteAccount'])->name('delete-account');
        Route::post('/delete-account', [AdminController::class, 'deleteAccount'])->name('delete-account.post');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::post('/dashboard/status', [UserController::class, 'updateStatus'])->name('status.update');
        Route::post('/dashboard/report', [UserController::class, 'submitReport'])->name('report.submit');
        Route::post('/dashboard/status/{index}/delete', [UserController::class, 'deleteStatus'])->name('status.delete');
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
        Route::get('/settings', [UserController::class, 'settings'])->name('settings');

        Route::get('/change-username', [UserController::class, 'showChangeUsername'])->name('change-username');
        Route::post('/change-username', [UserController::class, 'changeUsername'])->name('change-username.post');

        Route::get('/change-password', [UserController::class, 'showChangePassword'])->name('change-password');
        Route::post('/change-password', [UserController::class, 'changePassword'])->name('change-password.post');

        Route::get('/delete-account', [UserController::class, 'showDeleteAccount'])->name('delete-account');
        Route::post('/delete-account', [UserController::class, 'deleteAccount'])->name('delete-account.post');
    });
});
