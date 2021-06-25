<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin | admin
Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin'], function(){
    // Login & Registration
    Route::get('/login', 'Auth\LoginController@showLoginForm');
    Route::get('/register', 'Auth\RegisterController@showRegisterForm');
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/register', 'Auth\RegisterController@create');

    Route::group(['middleware' => 'auth:admin'], function(){
        Route::get('/', 'DashboardController@index');
        Route::get('/approve_seller', 'SellerController@approve_seller')->name('approve_seller');
        Route::get('/reject_seller', 'SellerController@reject_seller')->name('reject_seller');
    });
});

// Buyer | buyer
Route::group(['namespace' => 'App\Http\Controllers\Buyer'], function(){
    // Login & Registration
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::get('/register', 'Auth\RegisterController@showRegisterForm')->name('register');
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/register', 'Auth\RegisterController@create');

    // Forgot/Reset Password
    Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('buyer.password.request');                                     
    Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('buyer.password.reset');
    Route::post('/password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('buyer.password.email');
    Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('buyer.password.update');

    Route::group(['middleware' => ['auth:buyer', 'verified']], function(){
        Route::get('/', 'DashboardController@index');
    });
});

// Seller | seller
Route::group(['namespace' => 'App\Http\Controllers\Seller', 'prefix' => 'seller'], function(){
    // Login & Registration
    Route::get('/login', 'Auth\LoginController@showLoginForm');
    Route::get('/register', 'Auth\RegisterController@showRegisterForm');
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/register', 'Auth\RegisterController@create');

    // Forgot/Reset Password
    Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('seller.password.request');                                     
    Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('seller.password.reset');
    Route::post('/password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('seller.password.email');
    Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('seller.password.update');

    Route::group(['middleware' => ['auth:seller', 'verified', 'seller.is_approved']], function(){
        Route::get('/', 'DashboardController@index');
    });
});

// Auth
Route::group(['namespace' => 'App\Http\Controllers\Auth'], function(){
    // TWILIO | OTP
    Route::get('/otp/send_code', 'TwilioController@sendOTPCode')->name('send_otp_code');
    Route::get('/otp/verify_code', 'TwilioController@verifyOTPCode')->name('verify_otp_code');

    // Email Verification
    Route::group(['middleware' => 'auth:buyer,seller', 'prefix' => 'email'], function(){
        Route::get('/verify', 'EmailVerificationController@showVerificationNotice')->name('verification.notice');
        Route::get('/verify/{id}/{hash}', 'EmailVerificationController@verify')->name('verification.verify');
        Route::post('/verification-notification', 'EmailVerificationController@resend')->middleware('throttle:6,1')->name('verification.send');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
