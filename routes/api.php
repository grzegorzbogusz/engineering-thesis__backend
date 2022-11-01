<?php

use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\User\DeleteAccountController;
use App\Http\Controllers\User\UpdatePasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', RegisterUserController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');
Route::post('/logout', LogoutController::class)->middleware('auth:sanctum')->name('logout');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['auth:sanctum', 'signed', 'throttle:6,1'])->name('verification.verify');
Route::post('/email/verification-notification', EmailVerificationNotificationController::class)->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');

Route::post('/forgot-password', PasswordResetLinkController::class)->name('password.email');
Route::post('/reset-password', NewPasswordController::class)->name('password.update');

Route::middleware(['auth:sanctum', 'verified'])->prefix('user')->group(function () {
    Route::put('password', UpdatePasswordController::class)->name('change.password');
    Route::delete('delete', DeleteAccountController::class)->name('delete.account');
});

Route::middleware(['auth:sanctum', 'verified', 'can:access-admin-panel'])->prefix('admin')->group(function () {
    Route::apiResource('users', UserManagementController::class)->only(['index', 'show', 'destroy']);
});
