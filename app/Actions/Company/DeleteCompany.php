<?php

declare(strict_types=1);

namespace App\Actions\Company;

use App\Actions\Company\Contracts\DeletesCompanies;
use App\Models\Company;
use Throwable;

final class DeleteCompany implements DeletesCompanies
{
    /**
     * @throws Throwable
     */
    public function delete(Company $company): bool
    {
        $company->getFirstMedia('cover')?->delete();

        return ! ( ! $company->deleteOrFail())



        ;
    }
}
