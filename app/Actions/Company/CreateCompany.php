<?php

declare(strict_types=1);

namespace App\Actions\Company;

use App\Actions\Company\Contracts\CreatesCompanies;
use App\Actions\Company\Contracts\GeneratesCompaniesCodes;
use App\Actions\Company\Contracts\GeneratesCompaniesSlugs;
use App\Models\Company;
use App\Models\Employer;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

final class CreateCompany implements CreatesCompanies
{
    private array $fills;

    public function __construct(
        Company $company,
        protected GeneratesCompaniesSlugs $slugGenerator,
        protected GeneratesCompaniesCodes $codeGenerator,
    )
    {
        $this->fills = array_diff($company->getFillable(), ['code', 'slug', 'employer_id']);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function create(Employer $employer, array $inputs): Company
    {
        $data = Arr::only($inputs, $this->fills);
        $data['code'] = $this->codeGenerator->generate();
        $data['slug'] = $this->slugGenerator->generate($data['name']);

        $cover = Arr::get($inputs, 'cover');

        return tap($employer->company()->create($data), function (Company $company) use ($cover): void {
            if ($cover) {
                $company->addMedia($cover)->toMediaCollection('cover');
            }
        });
    }
}
