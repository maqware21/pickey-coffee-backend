<?php

use App\Http\Controllers\{CategoryController, ForgotPasswordController, LocationController, LoginController, ProfileController, VerifyEmailController};
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

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

Route::group(['prefix' => 'location', 'middleware' => ('auth:sanctum'), 'controller' => LocationController::class], function () {
	Route::get('list', 'list');
	Route::post('create', 'save');
	Route::post('update/{id}', 'update');
	Route::post('delete/{id}', 'delete');
});

Route::group(['prefix' => 'profile', 'middleware' => ('auth:sanctum'), 'controller' => ProfileController::class], function () {
	
	Route::post('update', 'update');
	Route::post('change_password', 'change_password');
});

Route::group(['prefix' => 'category', 'middleware' => ('auth:sanctum'), 'controller' => CategoryController::class], function () {
	
	Route::post('create', 'create');
	Route::post('list', 'list');
	Route::post('update/{id}', 'update');
	Route::post('delete/{id}', 'delete');
});
