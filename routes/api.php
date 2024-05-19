<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\ApprenticeController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployerController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\VacancyController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', LoginController::class)->name('login');
Route::post('/auth/register', RegisterController::class)->name('register');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', LogoutController::class)->name('logout');

    Route::apiResources([
        'admins' => AdminController::class,
        'employers' => EmployerController::class,
        'apprentices' => ApprenticeController::class,
        'employers.companies' => CompanyController::class,
        'vacancies' => VacancyController::class,
        'applications' => ApplicationController::class,
        'reviews' => ReviewController::class,
    ]);
});
