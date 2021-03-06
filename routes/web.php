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
    Route::post('/login', 'Auth\LoginController@login')->name('admin.login');
    Route::post('/register', 'Auth\RegisterController@create')->name('admin.register');
    Route::post('/logout', 'Auth\LoginController@adminLogout')->name('admin.logout');

    // Forgot/Reset Password
    Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('/password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('admin.password.update');

    Route::group(['middleware' => ['auth:admin', 'role:admin']], function(){
        // Dashboard
        Route::get('/', 'DashboardController@index');

        // seller
        Route::get('/sellers', 'SellerController@index')->name('seller_index');
        Route::get('/add_seller', 'SellerController@add_seller')->name('add_seller');
        Route::post('/create_seller', 'SellerController@create_seller')->name('create_seller');
        Route::get('/edit_seller/{slug}', 'SellerController@edit_seller')->name('edit_seller');
        Route::put('/update_seller/{slug}', 'SellerController@update_seller')->name('update_seller');
        Route::get('/approve_seller', 'SellerController@approve_seller')->name('approve_seller');
        Route::get('/reject_seller', 'SellerController@reject_seller')->name('reject_seller');
        Route::get('/activate_seller', 'SellerController@activate_seller')->name('activate_seller');
        Route::get('/deactivate_seller', 'SellerController@deactivate_seller')->name('deactivate_seller');
        Route::get('/search_sellers', 'SellerController@search_sellers')->name('search_sellers');

        // shipping_region
        Route::post('/create_shipping_region', 'ShippingRegionController@create_shipping_region')->name('create_shipping_region');
        Route::get('/update_shipping_region/{id}', 'ShippingRegionController@update_shipping_region')->name('update_shipping_region');
        Route::get('/destroy_shipping_region/{id}', 'ShippingRegionController@destroy_shipping_region')->name('destroy_shipping_region');
    });
});

// Buyer | buyer
Route::group(['namespace' => 'App\Http\Controllers\Buyer'], function(){
    // Login & Registration
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::get('/register', 'Auth\RegisterController@showRegisterForm')->name('register');
    Route::post('/login', 'Auth\LoginController@login')->name('buyer.login');
    Route::post('/register', 'Auth\RegisterController@create')->name('buyer.register');
    Route::post('/logout', 'Auth\LoginController@buyerLogout')->name('buyer.logout');

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
    Route::post('/login', 'Auth\LoginController@login')->name('seller.login');
    Route::post('/register', 'Auth\RegisterController@create')->name('seller.register');
    Route::post('/logout', 'Auth\LoginController@sellerLogout')->name('seller.logout');

    // Forgot/Reset Password
    Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('seller.password.request');
    Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('seller.password.reset');
    Route::post('/password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('seller.password.email');
    Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('seller.password.update');
    
    // province
    Route::get('/province/{id}', 'ProvinceController@find')->name('find_province');

    Route::group(['middleware' => ['auth:seller', 'role:seller', 'verified', 'seller.is_approved', 'seller.is_active']], function(){
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
