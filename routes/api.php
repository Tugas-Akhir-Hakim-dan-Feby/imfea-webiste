<?php

use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\Region\CityController;
use App\Http\Controllers\API\WebinarController;
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

Route::prefix('region')->name('api.region.')->group(function () {
    Route::prefix('city')->name('city.')->group(function () {
        Route::get('/{provinceId}', [CityController::class, 'index'])->name('index');
    });
});

Route::prefix('payment')->name('payment.')->group(function () {
    Route::post('callback', [PaymentController::class, 'callback'])->name('callback');
});

Route::resource('webinar', WebinarController::class, [
    "as" => "api"
])->middleware('auth:sanctum');

Route::put('news/update-status/{news}', [NewsController::class, 'updateStatus'])
    ->name('web.news.update.status')
    ->middleware('auth:sanctum');
Route::resource('news', NewsController::class, [
    "as" => "api"
])->middleware('auth:sanctum');
