<?php


use App\Http\Controllers\{CartController, CartDetailController, CategoryController, ForgotPasswordController, LocationController, LoginController, OrderController, PaymentController, ProductController, ProfileController, VerifyEmailController};
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

Route::group(['prefix' => 'location', 'middleware' => ('auth:sanctum'), 'controller' => LocationController::class], function () {
	Route::get('list', 'list');
	Route::post('create', 'save');
	Route::post('update/{id}', 'update');
	Route::post('delete/{id}', 'delete');
});

// Product Api's List
Route::group(['prefix' => 'product', 'middleware' => ('auth:sanctum'), 'controller' => ProductController::class], function () {
	Route::get('list', 'list');
	Route::post('create', 'save');
	Route::get('show/{id}', 'show');
	Route::post('update/{id}', 'update');
	Route::post('delete/{id}', 'delete');
});

Route::group(['prefix' => 'profile', 'middleware' => ('auth:sanctum'), 'controller' => ProfileController::class], function () {
	
	Route::post('update', 'update');
	Route::post('change_password', 'change_password');
});

//Categories APIs
Route::group(['prefix' => 'category', 'middleware' => ('auth:sanctum'), 'controller' => CategoryController::class], function () {
	
	Route::post('create', 'create');
	Route::post('list', 'list');
	Route::post('update/{id}', 'update');
	Route::post('delete/{id}', 'delete');
});

//Cart APIs
Route::group(['prefix' => 'cart', 'middleware' => ('auth:sanctum'), 'controller' => CartController::class], function () {
	Route::get('list', 'list');
	Route::post('create', 'save');
	Route::get('show/{id}', 'show');
	Route::post('update/{id}', 'update');
	Route::post('delete/{id}', 'delete');
});

//Payment Apis
Route::group(['prefix' => 'payment', 'middleware' => ('auth:sanctum'), 'controller' => PaymentController::class], function () {
	Route::get('list', 'list');
	Route::post('create', 'save');
	Route::get('show/{id}', 'show');
	Route::post('update/{id}', 'update');
	Route::post('delete/{id}', 'delete');
});
//Order APIs
Route::group(['prefix' => 'order', 'middleware' => ('auth:sanctum'), 'controller' => OrderController::class], function () {
	Route::get('list', 'list');
	Route::post('create', 'save');
	Route::get('show/{id}', 'show');
	Route::post('update/{id}', 'update');
	Route::post('delete/{id}', 'delete');
});

