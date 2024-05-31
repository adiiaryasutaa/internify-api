<?php

declare(strict_types=1);

namespace App\Actions\Company;

use App\Actions\Company\Contracts\GeneratesCompaniesCodes;
use App\Actions\Company\Contracts\GeneratesCompaniesSlugs;
use App\Actions\Company\Contracts\UpdatesCompanies;
use App\Models\Company;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

final class UpdateCompany implements UpdatesCompanies
{
    private array $fills;

    public function __construct(
        Company                           $company,
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
    public function update(Company $company, array $inputs): bool
    {
        $data = Arr::only($inputs, $this->fills);

        if (!$company->update($data)) {
            return false;
        }

        if ($cover = Arr::get($inputs, 'cover')) {
            $company->clearMediaCollection('cover');
            $company->addMedia($cover)->toMediaCollection('cover');
        }

        return true;
    }
}
