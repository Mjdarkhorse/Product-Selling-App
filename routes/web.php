<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
});

Route::get('/register', [AuthController::class, 'registerView'])->name('registerView');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/verify/{token}', [VerificationController::class, 'verify'])->name('verify');

Route::get('/login', [AuthController::class, 'loginView'])->name('loginView');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/forget-Password', [AuthController::class, 'forget_PasswordView'])->name('forget_PasswordView');
Route::post('/forget-Password', [AuthController::class, 'forget_Password'])->name('forget_Password');

Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordView'])->name('resetPasswordView');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::get('/updated-Password', [AuthController::class, 'updatePassword'])->name('updatePassword');

Route::get('/mail-verification', [AuthController::class, 'mailVerificationView'])->name('mailVerificationView');
Route::post('/mail-verification', [AuthController::class, 'mailVerification'])->name('mailVerification');


Route::get('/user/dashboard', function () {
    return 'User Dashboard';
})->name('user.dashboard');
Route::get('/admin/dashboard', function () {
    return 'Admin Dashboard';
})->name('admin.dashboard');
