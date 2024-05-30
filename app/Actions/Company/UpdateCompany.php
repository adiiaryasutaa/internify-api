<?php

declare(strict_types=1);

namespace App\Actions\Company;

use App\Actions\Company\Contracts\UpdatesCompanies;
use App\Models\Company;
use Illuminate\Support\Arr;
use Throwable;

final class UpdateCompany implements UpdatesCompanies
{
    /**
     * @throws Throwable
     */
    public function update(Company $company, array $inputs): bool
    {
        $cover = Arr::pull($inputs, 'cover');

        if ( ! $company->updateOrFail($inputs)) {
            return false;
        }

        if ($cover) {
            $company->addMedia($cover)->toMediaCollection('cover');
        }

        return true;
    }
}
