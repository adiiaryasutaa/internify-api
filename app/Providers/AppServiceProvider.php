<?php

declare(strict_types=1);

namespace App\Providers;

use App\Actions\Admin\Contracts\CreatesAdmins;
use App\Actions\Admin\Contracts\DeletesAdmins;
use App\Actions\Admin\Contracts\GeneratesAdminsCodes;
use App\Actions\Admin\Contracts\GeneratesAdminsSlugs;
use App\Actions\Admin\Contracts\UpdatesAdmins;
use App\Actions\Admin\CreateAdmin;
use App\Actions\Admin\DeleteAdmin;
use App\Actions\Admin\GenerateAdminsCode;
use App\Actions\Admin\GenerateAdminSlug;
use App\Actions\Admin\UpdateAdmin;
use App\Actions\Application\Contracts\CreatesApplications;
use App\Actions\Application\Contracts\DeletesApplications;
use App\Actions\Application\Contracts\GeneratesApplicationsCodes;
use App\Actions\Application\Contracts\GeneratesApplicationsSlugs;
use App\Actions\Application\Contracts\UpdatesApplications;
use App\Actions\Application\CreateApplication;
use App\Actions\Application\DeleteApplication;
use App\Actions\Application\GenerateApplicationCode;
use App\Actions\Application\GenerateApplicationSlug;
use App\Actions\Application\UpdateApplication;
use App\Actions\Apprentice\Contracts\CreatesApprentices;
use App\Actions\Apprentice\Contracts\DeletesApprentices;
use App\Actions\Apprentice\Contracts\GeneratesApprenticesCodes;
use App\Actions\Apprentice\Contracts\GeneratesApprenticesSlugs;
use App\Actions\Apprentice\Contracts\UpdatesApprentices;
use App\Actions\Apprentice\CreateApprentice;
use App\Actions\Apprentice\DeleteApprentice;
use App\Actions\Apprentice\GenerateApprenticeCode;
use App\Actions\Apprentice\GenerateApprenticeSlug;
use App\Actions\Apprentice\UpdateApprentice;
use App\Actions\Auth\AuthenticateUser;
use App\Actions\Auth\Contracts\AuthenticatesUsers;
use App\Actions\Auth\Contracts\LogoutsUsers;
use App\Actions\Auth\Contracts\RegistersUsers;
use App\Actions\Auth\LogoutUser;
use App\Actions\Auth\RegisterUser;
use App\Actions\Category\Contracts\CreatesCategories;
use App\Actions\Category\Contracts\DeletesCategories;
use App\Actions\Category\Contracts\GeneratesCategoriesCodes;
use App\Actions\Category\Contracts\GeneratesCategoriesSlugs;
use App\Actions\Category\Contracts\UpdatesCategories;
use App\Actions\Category\CreateCategory;
use App\Actions\Category\DeleteCategory;
use App\Actions\Category\GenerateCategoryCode;
use App\Actions\Category\GenerateCategorySlug;
use App\Actions\Category\UpdateCategory;
use App\Actions\Company\Contracts\CreatesCompanies;
use App\Actions\Company\Contracts\DeletesCompanies;
use App\Actions\Company\Contracts\GeneratesCompaniesCodes;
use App\Actions\Company\Contracts\GeneratesCompaniesSlugs;
use App\Actions\Company\Contracts\UpdatesCompanies;
use App\Actions\Company\CreateCompany;
use App\Actions\Company\DeleteCompany;
use App\Actions\Company\GenerateCompanyCode;
use App\Actions\Company\GenerateCompanySlug;
use App\Actions\Company\UpdateCompany;
use App\Actions\Employer\Contracts\CreatesEmployers;
use App\Actions\Employer\Contracts\DeletesEmployers;
use App\Actions\Employer\Contracts\GeneratesEmployersCodes;
use App\Actions\Employer\Contracts\GeneratesEmployersSlugs;
use App\Actions\Employer\Contracts\UpdatesEmployers;
use App\Actions\Employer\CreateEmployer;
use App\Actions\Employer\DeleteEmployer;
use App\Actions\Employer\GenerateEmployerCode;
use App\Actions\Employer\GenerateEmployerSlug;
use App\Actions\Employer\UpdateEmployer;
use App\Actions\Review\Contracts\CreatesReviews;
use App\Actions\Review\Contracts\DeletesReviews;
use App\Actions\Review\Contracts\GeneratesReviewsCodes;
use App\Actions\Review\Contracts\GeneratesReviewsSlugs;
use App\Actions\Review\Contracts\UpdatesReviews;
use App\Actions\Review\CreateReview;
use App\Actions\Review\DeleteReview;
use App\Actions\Review\GenerateReviewCode;
use App\Actions\Review\GenerateReviewSlug;
use App\Actions\Review\UpdateReview;
use App\Actions\User\Contracts\CreatesUsers;
use App\Actions\User\Contracts\DeletesUsers;
use App\Actions\User\Contracts\UpdatesUsers;
use App\Actions\User\CreateUser;
use App\Actions\User\DeleteUser;
use App\Actions\User\UpdateUser;
use App\Actions\Vacancy\Contracts\CreatesVacancies;
use App\Actions\Vacancy\Contracts\DeletesVacancies;
use App\Actions\Vacancy\Contracts\GeneratesVacanciesCodes;
use App\Actions\Vacancy\Contracts\GeneratesVacanciesSlugs;
use App\Actions\Vacancy\Contracts\UpdatesVacancies;
use App\Actions\Vacancy\CreateVacancy;
use App\Actions\Vacancy\DeleteVacancy;
use App\Actions\Vacancy\GenerateVacancyCode;
use App\Actions\Vacancy\GenerateVacancySlug;
use App\Actions\Vacancy\UpdateVacancy;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        CreatesUsers::class => CreateUser::class,
        UpdatesUsers::class => UpdateUser::class,
        DeletesUsers::class => DeleteUser::class,

        CreatesAdmins::class => CreateAdmin::class,
        UpdatesAdmins::class => UpdateAdmin::class,
        DeletesAdmins::class => DeleteAdmin::class,
        GeneratesAdminsSlugs::class => GenerateAdminSlug::class,
        GeneratesAdminsCodes::class => GenerateAdminsCode::class,

        CreatesEmployers::class => CreateEmployer::class,
        UpdatesEmployers::class => UpdateEmployer::class,
        DeletesEmployers::class => DeleteEmployer::class,
        GeneratesEmployersSlugs::class => GenerateEmployerSlug::class,
        GeneratesEmployersCodes::class => GenerateEmployerCode::class,

        CreatesApprentices::class => CreateApprentice::class,
        UpdatesApprentices::class => UpdateApprentice::class,
        DeletesApprentices::class => DeleteApprentice::class,
        GeneratesApprenticesSlugs::class => GenerateApprenticeSlug::class,
        GeneratesApprenticesCodes::class => GenerateApprenticeCode::class,

        CreatesCompanies::class => CreateCompany::class,
        UpdatesCompanies::class => UpdateCompany::class,
        DeletesCompanies::class => DeleteCompany::class,
        GeneratesCompaniesSlugs::class => GenerateCompanySlug::class,
        GeneratesCompaniesCodes::class => GenerateCompanyCode::class,

        CreatesCategories::class => CreateCategory::class,
        UpdatesCategories::class => UpdateCategory::class,
        DeletesCategories::class => DeleteCategory::class,
        GeneratesCategoriesSlugs::class => GenerateCategorySlug::class,
        GeneratesCategoriesCodes::class => GenerateCategoryCode::class,

        CreatesVacancies::class => CreateVacancy::class,
        UpdatesVacancies::class => UpdateVacancy::class,
        DeletesVacancies::class => DeleteVacancy::class,
        GeneratesVacanciesSlugs::class => GenerateVacancySlug::class,
        GeneratesVacanciesCodes::class => GenerateVacancyCode::class,

        CreatesApplications::class => CreateApplication::class,
        UpdatesApplications::class => UpdateApplication::class,
        DeletesApplications::class => DeleteApplication::class,
        GeneratesApplicationsSlugs::class => GenerateApplicationSlug::class,
        GeneratesApplicationsCodes::class => GenerateApplicationCode::class,

        CreatesReviews::class => CreateReview::class,
        UpdatesReviews::class => UpdateReview::class,
        DeletesReviews::class => DeleteReview::class,
        GeneratesReviewsSlugs::class => GenerateReviewSlug::class,
        GeneratesReviewsCodes::class => GenerateReviewCode::class,

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
