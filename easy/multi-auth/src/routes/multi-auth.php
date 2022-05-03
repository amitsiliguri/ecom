<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Easy\MultiAuth\Http\Controllers\Auth\Admin\AdminUserController;
use Easy\MultiAuth\Http\Controllers\Auth\Admin\AdminUserUpdateController;
use Easy\MultiAuth\Http\Controllers\Auth\Admin\AuthenticatedSessionController;
use Easy\MultiAuth\Http\Controllers\Auth\Admin\ConfirmablePasswordController;
use Easy\MultiAuth\Http\Controllers\Auth\Admin\EmailVerificationNotificationController;
use Easy\MultiAuth\Http\Controllers\Auth\Admin\EmailVerificationPromptController;
use Easy\MultiAuth\Http\Controllers\Auth\Admin\NewPasswordController;
use Easy\MultiAuth\Http\Controllers\Auth\Admin\PasswordResetLinkController;
use Easy\MultiAuth\Http\Controllers\Auth\Admin\RegisteredUserController;
use Easy\MultiAuth\Http\Controllers\Auth\Admin\VerifyEmailController;
use Easy\MultiAuth\Http\Controllers\Auth\AuthenticatedSessionController as FrontendAuthenticatedSessionController;
use Easy\MultiAuth\Http\Controllers\Auth\ConfirmablePasswordController as FrontendConfirmablePasswordController;
use Easy\MultiAuth\Http\Controllers\Auth\EmailVerificationNotificationController as FrontendEmailVerificationNotificationController;
use Easy\MultiAuth\Http\Controllers\Auth\EmailVerificationPromptController as FrontendEmailVerificationPromptController;
use Easy\MultiAuth\Http\Controllers\Auth\NewPasswordController as FrontendNewPasswordController;
use Easy\MultiAuth\Http\Controllers\Auth\PasswordResetLinkController as FrontendPasswordResetLinkController;
use Easy\MultiAuth\Http\Controllers\Auth\RegisteredUserController as FrontendRegisteredUserController;
use Easy\MultiAuth\Http\Controllers\Auth\VerifyEmailController as FrontendVerifyEmailController;


Route::prefix('admin')->name('admin.')->middleware(['web'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth:admin', 'admin.verified'])->name('dashboard');

    Route::prefix('users')->name('users.')->middleware(['auth:admin', 'admin.verified'])->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [AdminUserUpdateController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [AdminUserUpdateController::class, 'update'])->name('update');
    });

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->middleware('guest:admin')
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest:admin');

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->middleware(['auth:admin', 'admin.verified'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware(['auth:admin', 'admin.verified']);

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->middleware('guest:admin')
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest:admin')
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->middleware('guest:admin')
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest:admin')
        ->name('password.update');

    Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->middleware('auth:admin')
        ->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['auth:admin', 'signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth:admin', 'throttle:6,1'])
        ->name('verification.send');

    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->middleware('auth:admin')
        ->name('password.confirm');

    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
        ->middleware('auth:admin');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth:admin')
        ->name('logout');
});


Route::middleware(['web'])->group(function () {
    Route::get('/home', function () {
        return view('dashboard');
    })->middleware(['auth:web'])->name('dashboard');

    Route::get('/register', [FrontendRegisteredUserController::class, 'create'])
        ->middleware('guest:web')
        ->name('register');

    Route::post('/register', [FrontendRegisteredUserController::class, 'store'])
        ->middleware('guest:web');

    Route::get('/login', [FrontendAuthenticatedSessionController::class, 'create'])
        ->middleware('guest:web')
        ->name('login');

    Route::post('/login', [FrontendAuthenticatedSessionController::class, 'store'])
        ->middleware('guest:web');

    Route::get('/forgot-password', [FrontendPasswordResetLinkController::class, 'create'])
        ->middleware('guest:web')
        ->name('password.request');

    Route::post('/forgot-password', [FrontendPasswordResetLinkController::class, 'store'])
        ->middleware('guest:web')
        ->name('password.email');

    Route::get('/reset-password/{token}', [FrontendNewPasswordController::class, 'create'])
        ->middleware('guest:web')
        ->name('password.reset');

    Route::post('/reset-password', [FrontendNewPasswordController::class, 'store'])
        ->middleware('guest:web')
        ->name('password.update');

    Route::get('/verify-email', [FrontendEmailVerificationPromptController::class, '__invoke'])
        ->middleware('auth:web')
        ->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', [FrontendVerifyEmailController::class, '__invoke'])
        ->middleware(['auth:web', 'signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [FrontendEmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth:web', 'throttle:6,1'])
        ->name('verification.send');

    Route::get('/confirm-password', [FrontendConfirmablePasswordController::class, 'show'])
        ->middleware('auth:web')
        ->name('password.confirm');

    Route::post('/confirm-password', [FrontendConfirmablePasswordController::class, 'store'])
        ->middleware('auth:web');

    Route::post('/logout', [FrontendAuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth:web')
        ->name('logout');
});
