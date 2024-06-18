<?php

declare(strict_types=1);

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\ApprenticeController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\CompanyReviewController;
use App\Http\Controllers\Api\CompanyVacancyController;
use App\Http\Controllers\Api\EmployerController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\RouteFallbackController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\VacancyApplicationController;
use App\Http\Controllers\Api\VacancyController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\NotAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('/auth/logout', LogoutController::class)->name('logout');

    Route::prefix('/admin')
        ->name('admin.')
        ->middleware(Admin::class)
        ->group(function (): void {
            Route::apiResource('admins', AdminController::class);
            Route::apiResource('employers', EmployerController::class);
            Route::apiResource('apprentices', ApprenticeController::class);
            Route::apiResource('companies', CompanyController::class);
            Route::apiResource('categories', CategoryController::class);
            Route::apiResource('vacancies', VacancyController::class);
            Route::apiResource('applications', ApplicationController::class);
            Route::apiResource('reviews', ReviewController::class);
        });

    Route::middleware(NotAdmin::class)->group(function (): void {
        Route::apiResource('companies.reviews', CompanyReviewController::class)->only(['store']);
        Route::apiResource('vacancies.applications', VacancyApplicationController::class)->except(['update', 'destroy']);
        Route::apiResource('applications', ApplicationController::class)->except(['store', 'destroy']);
        Route::apiResource('reviews', ReviewController::class)->only(['index']);
    });
});

Route::apiResource('companies', CompanyController::class)->only(['index', 'show']);
Route::apiResource('companies.vacancies', CompanyVacancyController::class)->only(['index']);
Route::apiResource('companies.reviews', CompanyReviewController::class)->except(['show']);

Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
Route::apiResource('vacancies', VacancyController::class);

Route::get('/search', SearchController::class)->name('search');

Route::post('/auth/login', LoginController::class)->name('login');
Route::post('/auth/register', RegisterController::class)->name('register');

Route::fallback(RouteFallbackController::class);
