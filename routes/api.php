<?php

use App\Http\Controllers\API\ApprovalController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\TravelPlaymentController;
use App\Http\Controllers\Auth\LoginController;
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

Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
    Route::post('/register', [LoginController::class, 'register'])->name('register');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    // Route::post('/logout',[LoginController::class,'logout'])->name('logout');
});
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::group(['as' => 'payments.', 'prefix' => 'payments'], function () {
        Route::post('/create', [PaymentController::class, 'create'])->name('create');
        Route::put('/edit/{id}', [PaymentController::class, 'edit'])->name('edit');
        Route::get('/show/{id}', [PaymentController::class, 'show'])->name('show');
        Route::get('/showAll', [PaymentController::class, 'showAll'])->name('show_all');
        Route::delete('/delete/{id}', [PaymentController::class, 'destroy'])->name('delete');
    });

    Route::group(['as' => 'travel_payments.', 'prefix' => 'travel_payments'], function () {
        Route::post('/create', [TravelPlaymentController::class, 'create'])->name('create');
        Route::put('/edit/{id}', [TravelPlaymentController::class, 'edit'])->name('edit');
        Route::get('/show/{id}', [TravelPlaymentController::class, 'show'])->name('show');
        Route::get('/showAll', [TravelPlaymentController::class, 'showAll'])->name('show_all');
        Route::delete('/delete/{id}', [TravelPlaymentController::class, 'destroy'])->name('delete');
    });

    Route::group(['as' => 'approve.', 'prefix' => 'approve'], function () {
        Route::post('/requestApproval', [ApprovalController::class, 'requestApproval'])->name('request_approval');
    });

    Route::group(['middleware' => ['payment_approval'],'as' => 'approve.', 'prefix' => 'approve'], function () {
        Route::put('/approvePayment/{id}', [ApprovalController::class, 'approvePayment'])->name('approve_ayment');
        Route::get('/sumPayments', [ApprovalController::class, 'sumPayments'])->name('sum_payments');
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
