<?php

use App\Http\Controllers\WEB\Auth\LoginController;
use App\Http\Controllers\WEB\Auth\LogoutController;
use App\Http\Controllers\WEB\Auth\RegisterController;
use App\Http\Controllers\WEB\HomeController;
use App\Http\Controllers\WEB\InvoiceController;
use App\Http\Controllers\WEB\NewsController;
use App\Http\Controllers\WEB\MemberController;
use App\Http\Controllers\WEB\WebinarController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('/membership-card', [WebinarController::class, 'generateMembershipCard']);

Route::middleware(['guest'])
    ->prefix('auth')
    ->name('web.auth.')
    ->group(function () {
        Route::prefix('login')->name('login.')->group(function () {
            Route::get('/', [LoginController::class, 'index'])
                ->name('index');
            Route::post('/', [LoginController::class, 'process'])
                ->name('process');
        });

        Route::prefix('register')->name('register.')->group(function () {
            Route::get('/', [RegisterController::class, 'index'])
                ->name('index');
            Route::post('/', [RegisterController::class, 'process'])
                ->name('process');
        });
    });

Route::middleware(['auth'])
    ->name('web.')
    ->group(function () {
        Route::get('/', HomeController::class)
            ->name('home.index');
        Route::get('auth/logout', LogoutController::class)
            ->name('auth.logout');

        Route::prefix('invoice')->name('invoice.')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])
                ->name('index');
            Route::get('/{externalId}', [InvoiceController::class, 'show'])
                ->name('show');
        });

        Route::prefix('member')->name('member.')->group(function () {
            Route::get('register', [MemberController::class, 'index'])
                ->name('register.index');
            Route::post('register', [MemberController::class, 'process'])
                ->name('register.process');
        });

        Route::get('webinar/load-more', [WebinarController::class, 'loadMore'])
            ->name('webinar.load.more');
        Route::get('webinar/meet/{slug}', [WebinarController::class, 'meet'])
            ->name('webinar.meet');
        Route::get('webinar/background/{webinar}', [WebinarController::class, 'background'])
            ->name('webinar.background');
        Route::resource('webinar', WebinarController::class);

        Route::post('news/upload-image', [NewsController::class, 'uploadImageContent'])
            ->name('news.upload.image');
        Route::put('news/update-status/{news}', [NewsController::class, 'updateStatus'])
            ->name('news.update.status');
        Route::resource('news', NewsController::class);
    });
