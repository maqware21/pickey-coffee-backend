<?php

use App\Http\Controllers\{ForgotPasswordController, LoginController, VerifyEmailController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'user', 'controller' => LoginController::class], function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::post('logout', [LoginController::class, 'logout'])->middleware(['auth:sanctum']);

Route::post('forget-password', [ForgotPasswordController::class, 'SendEmailLink']);
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm']);


Route::post('send-verification-mail', [VerifyEmailController::class, 'SendVerificationEmail'])->middleware(['auth:sanctum']);
Route::post('verify-email', [VerifyEmailController::class, 'VerifyEmail']);   