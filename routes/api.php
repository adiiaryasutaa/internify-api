<?php

declare(strict_types=1);

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\ApprenticeController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployerController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\RouteFallbackController;
use App\Http\Controllers\Api\VacancyController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', LoginController::class)->name('login');
Route::post('/auth/register', RegisterController::class)->name('register');

Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('/auth/logout', LogoutController::class)->name('logout');

    Route::apiResource('admins', AdminController::class);
    Route::apiResource('employers', EmployerController::class);
    Route::apiResource('employers.company', CompanyController::class)->except(['show']);
    Route::apiResource('apprentices', ApprenticeController::class);
    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('vacancies', VacancyController::class);
    Route::apiResource('applications', ApplicationController::class);
    Route::apiResource('reviews', ReviewController::class);
});

Route::fallback(RouteFallbackController::class);
