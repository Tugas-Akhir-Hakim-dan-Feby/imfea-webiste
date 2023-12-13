<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\Auth\MeController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\Region\CityController;
use App\Http\Controllers\API\WebinarController;
use App\Http\Controllers\API\XenditController;
use App\Http\Controllers\API\UserController;
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

Route::prefix('auth')->name('api.auth.')->group(function () {
    Route::post('register', RegisterController::class)->name('register');

    Route::post('login', LoginController::class)->name('login');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('me', MeController::class)->name('me');

        Route::post('logout', LogoutController::class)->name('logout');
    });
});

Route::prefix('region')->name('api.region.')->group(function () {
    Route::prefix('city')->name('city.')->group(function () {
        Route::get('/{provinceId}', [CityController::class, 'index'])
            ->name('index');
    });
});

Route::prefix('payment')->name('payment.')->group(function () {
    Route::post('callback-invoice', [PaymentController::class, 'callbackInvoice'])
        ->name('callback.invoice');
    Route::post('callback-success-fva', [PaymentController::class, 'callbackSuccessFva'])
        ->name('callback.success.fva');
    Route::post('callback-recreated-fva', [PaymentController::class, 'callbackRecreatedFva'])
        ->name('callback.recreated.fva');
});


Route::middleware(['auth:sanctum'])->name('api.')->group(function () {
    Route::prefix('xendit')->name('xendit.')->group(function () {
        Route::get('list-va', [XenditController::class, 'listVA'])
            ->name('list.va');
        Route::post('create-va', [XenditController::class, 'createVA'])
            ->name('create.va');
    });

    Route::prefix('member')->name('member.')->group(function () {
        Route::post('register', [MemberController::class, 'register'])->name('register');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::post('/check-profile', [UserController::class, 'checkProfile'])->name('check.profile');
        Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('update.profile');
    });

    Route::resource('webinar', WebinarController::class);

    Route::put('news/update-status/{news}', [NewsController::class, 'updateStatus'])
        ->name('news.update.status');
    Route::resource('news', NewsController::class);
});
