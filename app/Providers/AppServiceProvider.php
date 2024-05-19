<?php

namespace App\Providers;

use App\Actions\Admin\Contracts\CreatesAdmins;
use App\Actions\Admin\Contracts\DeletesAdmins;
use App\Actions\Admin\Contracts\UpdatesAdmins;
use App\Actions\Admin\CreateAdmin;
use App\Actions\Admin\DeleteAdmin;
use App\Actions\Admin\UpdateAdmin;
use App\Actions\Application\Contracts\CreatesApplications;
use App\Actions\Application\Contracts\DeletesApplications;
use App\Actions\Application\Contracts\UpdatesApplications;
use App\Actions\Application\CreateApplication;
use App\Actions\Application\DeleteApplication;
use App\Actions\Application\UpdateApplication;
use App\Actions\Apprentice\Contracts\CreatesApprentices;
use App\Actions\Apprentice\Contracts\DeletesApprentices;
use App\Actions\Apprentice\Contracts\UpdatesApprentices;
use App\Actions\Apprentice\CreateApprentice;
use App\Actions\Apprentice\DeleteApprentice;
use App\Actions\Apprentice\UpdateApprentice;
use App\Actions\Auth\AuthenticateUser;
use App\Actions\Auth\Contracts\AuthenticatesUsers;
use App\Actions\Auth\Contracts\LogoutsUsers;
use App\Actions\Auth\Contracts\RegistersUsers;
use App\Actions\Auth\LogoutUser;
use App\Actions\Auth\RegisterUser;
use App\Actions\Employer\Contracts\CreatesEmployers;
use App\Actions\Employer\Contracts\DeletesEmployers;
use App\Actions\Employer\Contracts\UpdatesEmployers;
use App\Actions\Employer\CreateEmployer;
use App\Actions\Employer\DeleteEmployer;
use App\Actions\Employer\UpdateEmployer;
use App\Actions\Review\Contracts\CreatesReviews;
use App\Actions\Review\Contracts\DeletesReviews;
use App\Actions\Review\Contracts\UpdatesReviews;
use App\Actions\Review\CreateReview;
use App\Actions\Review\DeleteReview;
use App\Actions\Review\UpdateReview;
use App\Actions\User\Contracts\CreatesUsers;
use App\Actions\User\Contracts\DeletesUsers;
use App\Actions\User\Contracts\UpdatesUsers;
use App\Actions\User\CreateUser;
use App\Actions\User\DeleteUser;
use App\Actions\User\UpdateUser;
use App\Actions\Vacancy\Contracts\CreatesVacancies;
use App\Actions\Vacancy\Contracts\DeletesVacancies;
use App\Actions\Vacancy\Contracts\UpdatesVacancies;
use App\Actions\Vacancy\CreateVacancy;
use App\Actions\Vacancy\DeleteVacancy;
use App\Actions\Vacancy\UpdateVacancy;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        CreatesUsers::class => CreateUser::class,
        UpdatesUsers::class => UpdateUser::class,
        DeletesUsers::class => DeleteUser::class,

        CreatesAdmins::class => CreateAdmin::class,
        UpdatesAdmins::class => UpdateAdmin::class,
        DeletesAdmins::class => DeleteAdmin::class,

        CreatesEmployers::class => CreateEmployer::class,
        UpdatesEmployers::class => UpdateEmployer::class,
        DeletesEmployers::class => DeleteEmployer::class,

        CreatesApprentices::class => CreateApprentice::class,
        UpdatesApprentices::class => UpdateApprentice::class,
        DeletesApprentices::class => DeleteApprentice::class,

        CreatesVacancies::class => CreateVacancy::class,
        UpdatesVacancies::class => UpdateVacancy::class,
        DeletesVacancies::class => DeleteVacancy::class,

        CreatesApplications::class => CreateApplication::class,
        UpdatesApplications::class => UpdateApplication::class,
        DeletesApplications::class => DeleteApplication::class,

        CreatesReviews::class => CreateReview::class,
        UpdatesReviews::class => UpdateReview::class,
        DeletesReviews::class => DeleteReview::class,

        RegistersUsers::class => RegisterUser::class,
        AuthenticatesUsers::class => AuthenticateUser::class,
        LogoutsUsers::class => LogoutUser::class,
    ];

    public function boot(): void
    {
        Model::shouldBeStrict();
        Gate::defaultDenialResponse(Response::denyAsNotFound());
    }
}
