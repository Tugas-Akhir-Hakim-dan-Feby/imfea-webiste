<?php

use App\Http\Controllers\WEB\Auth\LoginController;
use App\Http\Controllers\WEB\Auth\LogoutController;
use App\Http\Controllers\WEB\Auth\NewPasswordController;
use App\Http\Controllers\WEB\Auth\RegisterController;
use App\Http\Controllers\WEB\Auth\ResetPasswordController;
use App\Http\Controllers\WEB\Auth\VerificationController;
use App\Http\Controllers\WEB\CourseController;
use App\Http\Controllers\WEB\ExamController;
use App\Http\Controllers\WEB\HomeController;
use App\Http\Controllers\WEB\InvoiceController;
use App\Http\Controllers\WEB\MembercardController;
use App\Http\Controllers\WEB\NewsController;
use App\Http\Controllers\WEB\MemberController;
use App\Http\Controllers\WEB\ProfileController;
use App\Http\Controllers\WEB\TopicController;
use App\Http\Controllers\WEB\TrainingController;
use App\Http\Controllers\WEB\WebinarController;
use App\Http\Controllers\WEB\RegionalController;
use App\Http\Controllers\WEB\User\OperatorController;
use App\Http\Controllers\WEB\User\AdminAppController;
use App\Http\Controllers\WEB\User\KorwilController;
use App\Http\Controllers\WEB\User\MemberController as MembershipController;
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

Route::get('membercard/{slug}', MembercardController::class)
    ->name('web.membercard');

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

        Route::prefix('reset-password')->name('reset-password.')->group(function () {
            Route::get('/', [ResetPasswordController::class, 'index'])->name('index');
            Route::post('/', [ResetPasswordController::class, 'process'])->name('process');
        });

        Route::prefix('new-password')->name('new-password.')->group(function () {
            Route::get('/', [NewPasswordController::class, 'index'])->name('index');
            Route::post('/', [NewPasswordController::class, 'process'])->name('process');
        });

        Route::get('verification', VerificationController::class)->name('verification');
    });

Route::middleware(['auth'])
    ->name('web.')
    ->group(function () {
        Route::prefix('member')->name('member.')->group(function () {
            Route::get('register', [MemberController::class, 'index'])
                ->name('register.index');
            Route::post('register', [MemberController::class, 'process'])
                ->name('register.process');
        });

        Route::prefix('invoice')->name('invoice.')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])
                ->name('index');
            Route::get('/{externalId}', [InvoiceController::class, 'show'])
                ->name('show');
        });

        Route::get('auth/logout', LogoutController::class)
            ->name('auth.logout');
    });

Route::middleware(['auth', 'check.membership'])
    ->name('web.')
    ->group(function () {
        Route::get('/', HomeController::class)
            ->name('home.index');

        Route::get('webinar/all', [WebinarController::class, 'all'])
            ->name('webinar.all');
        Route::get('webinar/load-more', [WebinarController::class, 'loadMore'])
            ->name('webinar.load.more');
        Route::get('webinar/meet/{slug}', [WebinarController::class, 'meet'])
            ->name('webinar.meet');
        Route::get('webinar/background/{webinar}', [WebinarController::class, 'background'])
            ->name('webinar.background');
        Route::post('webinar/register/{webinar}', [WebinarController::class, 'register'])
            ->name('webinar.register');
        Route::resource('webinar', WebinarController::class);

        Route::get('news/{date}/{month}/{year}/{slug}.html', [NewsController::class, 'showSlug'])
            ->name('news.show.slug');
        Route::post('news/upload-image', [NewsController::class, 'uploadImageContent'])
            ->name('news.upload.image');
        Route::put('news/update-status/{news}', [NewsController::class, 'updateStatus'])
            ->name('news.update.status');
        Route::resource('news', NewsController::class);

        Route::resource('training/{training}/topic', TopicController::class);

        Route::get('training/{trainingSlug}/learn/course/{courseSlug}', [CourseController::class, 'showSlug'])
            ->name('training.course.slug');
        Route::post('training/{trainingSlug}/learn/course/{courseSlug}', [CourseController::class, 'processSubmitted'])
            ->name('training.course.slug.process');

        Route::resource('training/{training}/course', CourseController::class);

        Route::resource('training/{training}/exam', ExamController::class);

        Route::get('training/all', [TrainingController::class, 'all'])
            ->name('training.all');
        Route::get('training/load-more', [TrainingController::class, 'loadMore'])
            ->name('training.load.more');
        Route::get('training/detail/{slug}', [TrainingController::class, 'showSlug'])
            ->name('training.show.slug');
        Route::post('training/register/{training}', [TrainingController::class, 'register'])
            ->name('training.register');
        Route::resource('training', TrainingController::class);

        Route::resource('regional', RegionalController::class);

        Route::prefix('user')->name('user.')->group(function () {
            Route::resource('admin-app', AdminAppController::class);
            Route::resource('operator', OperatorController::class);

            Route::get('korwil/clear', [KorwilController::class, 'clear'])->name('korwil.clear');
            Route::resource('korwil', KorwilController::class);

            Route::prefix('member')->name('member.')->group(function () {
                Route::get('/', [MembershipController::class, 'index'])->name('index');
            });
        });

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])
                ->name('index');

            Route::get('membercard', [ProfileController::class, 'membercard'])
                ->name('membercard');
        });
    });
