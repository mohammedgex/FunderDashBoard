<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ReceipysController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\user\AuthUsersController;
use App\Http\Controllers\user\IdentificationController;
use Illuminate\Support\Facades\Route;
use App\Filament\Pages\ShowUserProperties;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::post('/user/image/{id}', [AuthUsersController::class, 'image'])->name('user.image');

    Route::get('/categories', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/create-category', [CategoryController::class, 'form'])->name('categories.form');
    Route::get('/update-category/{id}', [CategoryController::class, 'formUpdate'])->name('categories.formUpdate');
    // add category
    Route::post('/category', [CategoryController::class, 'add'])->name('categories.add');
    // update category
    Route::post('/category/{id}', [CategoryController::class, 'update'])->name('categories.update');
    // delete category
    Route::delete('/category/{id}', [CategoryController::class, 'delete'])->name('categories.delete');


    Route::get('/terms', [TermsController::class, 'index'])->name('term.index');
    Route::get('/add-terms', [TermsController::class, 'create'])->name('term.create');
    Route::get('/update-terms/{id}', [TermsController::class, 'show'])->name('term.show');
    // add term
    Route::post('/terms', [TermsController::class, 'addTerm'])->name('term.add');
    // update term
    Route::post('/term/{id}', [TermsController::class, 'updateTerm'])->name('term.update'); //admin
    // delete term
    Route::delete('/term/{id}', [TermsController::class, 'delete'])->name('term.delete');


    Route::get('/properties', [PropertyController::class, 'index'])->name('property.index');
    Route::get('/properties/soldout', [PropertyController::class, 'soldout'])->name('property.soldout');
    Route::get('/properties/available', [PropertyController::class, 'available'])->name('property.available');
    Route::get('/properties/soldout/{id}', [PropertyController::class, 'gosoldout'])->name('property.gosoldout');
    Route::get('/properties/{id}', [PropertyController::class, 'readMore'])->name('property.readMore');
    Route::get('/create-property', [PropertyController::class, 'show'])->name('property.show');
    Route::post('/properties', [PropertyController::class, 'create'])->name('property.create');
    Route::delete('/properties/{id}', [PropertyController::class, 'delete'])->name('property.delete');
    Route::get('/properties/shares/{id}', [PropertyController::class, 'shares'])->name('property.shares');
    Route::get('/properties/shares/delete/{id}', [PropertyController::class, 'sharedelete'])->name('property.shares.delete');
    Route::get('/properties/user-shered/{id}', [PropertyController::class, 'property_shared_user'])->name('property.user.shered');
    Route::get('/properties/edit/{property_id}', [PropertyController::class, 'edit'])->name('property.edit');
    Route::post('/properties/update/{property_id}', [PropertyController::class, 'update'])->name('property.update');
    Route::get('/properties/{id}/{imagename}', [PropertyController::class, 'deleteImage'])->name('property.image.delete');

    Route::get('/timeline/{id}', [TimelineController::class, 'index'])->name('timeline.index');
    Route::post('/timeline/{id}', [TimelineController::class, 'create'])->name('timeline.create');
    Route::get('/timeline/delete/{id}', [TimelineController::class, 'delete'])->name('timeline.delete');
    Route::get('/timeline/edit/{id}', [TimelineController::class, 'show'])->name('timeline.edit');
    Route::post('/timeline/edit/{id}', [TimelineController::class, 'update'])->name('timeline.update');


    Route::get('/receipts', [ReceipysController::class, 'index'])->name('receipts.index');
    Route::get('/receipts/{id}', [ReceipysController::class, 'show'])->name('receipts.show');
    // accepted receipt
    Route::get('/receipt/accepted/{id}', [ReceipysController::class, 'accepted'])->name('receipts.accepted');
    // rejected receipt
    Route::get('/receipt/rejected/{id}', [ReceipysController::class, 'rejected'])->name('receipts.rejected');


    // all identification
    Route::get('/identification', [IdentificationController::class, 'allIdentification'])->name('identify.index'); //admin
    Route::get('/identification/{id}', [IdentificationController::class, 'show'])->name('identify.show');
    // identification valid
    Route::get('/identification/valid/{id}', [IdentificationController::class, 'valid'])->name('identify.valid'); //admin
    // identification not valid
    Route::get('/identification/not_valid/{id}', [IdentificationController::class, 'notValid'])->name('identify.notvalid'); //admin


    Route::get('/users', [AuthUsersController::class, 'users'])->name('user.index'); //admin
    Route::get('/users/{id}', [AuthUsersController::class, 'show'])->name('user.show'); //admin

    Route::get('/sales', [SaleController::class, 'index'])->name('sale.index');
    Route::get('/sales/accepted/{id}', [SaleController::class, 'accepted'])->name('sale.accepted');
    Route::get('/sales/rejected/{id}', [SaleController::class, 'rejected'])->name('sale.rejected');


    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::get('/payment/create', [PaymentController::class, 'add'])->name('payment.add');
    Route::post('/payment', [PaymentController::class, 'create'])->name('payment.create');
    Route::get('/payment/edit/{id}', [PaymentController::class, 'edit'])->name('payment.edit');
    Route::post('/payment/{id}', [PaymentController::class, 'update'])->name('payment.update');
    Route::get('/payment/delete/{id}', [PaymentController::class, 'delete'])->name('payment.delete');

    // rent
    // all rent 
    Route::get('/rent/{id}', [RentController::class, 'allRentforProperty'])->name('rent.show');
    // add rent
    Route::get('/rent/add/{id}', [RentController::class, 'add'])->name('rent.add');
    // create rent
    Route::post('/rent/create/{id}', [RentController::class, 'create'])->name('rent.create');
    Route::get('/rent/active/{id}', [RentController::class, 'active'])->name('rent.active');
    Route::get('/rent/not-active/{id}', [RentController::class, 'notActive'])->name('rent.not-active');
});
