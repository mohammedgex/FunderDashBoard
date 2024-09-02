<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ReceipysController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\user\AuthUsersController;
use App\Http\Controllers\user\IdentificationController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// LOGIN & REGISTER USERS

// register
Route::post('/user/register', [AuthUsersController::class, 'register']);
// login
Route::post('/user/login', [AuthUsersController::class, 'login']);
// send code to verification email
Route::post('/user/send-code', [AuthUsersController::class, 'sendCodeVerification']);
// Code comparison
Route::post('/user/verification', [AuthUsersController::class, 'verificationCode']);
// forget password
Route::post('/user/forget-password', [AuthUsersController::class, 'forgetPassword']);
// confirm code in forgot password
Route::post('/user/confirm-code', [AuthUsersController::class, 'verificationCodeWithResetPassword']);
// reset password in forgot password
Route::post('/user/reset-password', [AuthUsersController::class, 'resetPassword'])->middleware('auth:sanctum');
// reset password in old password
Route::post('/user/new-password', [AuthUsersController::class, 'resetPasswordWithOldPassword'])->middleware('auth:sanctum');
// login & register with google account
Route::get('/google/callback', [SocialiteController::class, 'handleGoogleCallback']);
// login & register with facebook account
Route::get('/facebook/callback', [SocialiteController::class, 'handleFacebookCallback']);

// user profile
Route::post('/profile', [AuthUsersController::class, 'profile'])->middleware('auth:sanctum');

// identification user
// add identification
Route::post('/user/identification', [IdentificationController::class, 'addIdentification']);


Route::middleware('auth:sanctum')->group(
    function () {
        // terms
        Route::get('/terms', [TermsController::class, 'terms']);

        // category
        Route::get('/category', [CategoryController::class, 'all']);
        // category by id
        Route::get('/category/{id}', [CategoryController::class, 'cateById']);


        // Property
        Route::get('/properties', [PropertyController::class, 'all']);
        // Property sold out
        Route::get('/properties/sold-out', [PropertyController::class, 'propertiesSoldout']);
        // Property available
        Route::get('/properties/available', [PropertyController::class, 'available']);
        // Property by id
        Route::get('/properties/{id}', [PropertyController::class, 'propById']);
        // get all properties by category name
        Route::get('/{categoryName}/properties', [PropertyController::class, 'propByCateName']);

        // fillter properties
        Route::post('/property/filter', [PropertyController::class, 'filter']);
        // all locations
        Route::get('/locations', [PropertyController::class, 'locations']);


        // get Timelines by property id
        Route::get('/timeline/{propId}', [TimelineController::class, 'getTimelines']);


        // get Favorites by user
        Route::get('/favorites', [FavoriteController::class, 'getFavoByUser']);
        // add Favorites
        Route::post('/favorites/{propertyId}', [FavoriteController::class, 'create']);
        // remove Favorite
        Route::delete('/favorites/{id}', [FavoriteController::class, 'delete']);
        // clear all Favorites
        Route::delete('/favorites', [FavoriteController::class, 'clearAll']);

        // payment methods
        // get all payments
        Route::get('/payment', [PaymentController::class, 'all']);


        // get receipts by user
        Route::get('/receipt', [ReceipysController::class, 'getReceiptsByuser']);
        // get receipt by id
        Route::get('/receipt/{id}', [ReceipysController::class, 'receiptById']);
        // get receipts by status
        Route::get('/receipt/status/{status}', [ReceipysController::class, 'receiptByStatus']);
        // create receipts
        Route::post('/receipt', [ReceipysController::class, 'create']);


        // sales property
        Route::get('/sales', [SaleController::class, 'sales']);
        // create sale property
        Route::post('/sales', [SaleController::class, 'create']);


        // Wallet 
        Route::get('/wallet', [WalletController::class, 'wallet']);
        // get Properties in which the user participates
        Route::get('/properties/shere/panding', [WalletController::class, 'propOfSheres']);
        Route::get('/properties/propertyDetails/{id}', [WalletController::class, 'propertyDetails']);
    }
);


// // notifications 
// // Notification::send($user, new Notifications('login', 'login true', '50'));
// // notifications in application
// Route::get('/notifications', [NotificationsController::class, 'all'])->middleware('auth:sanctum');