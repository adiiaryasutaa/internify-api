<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

final class SearchController extends Controller
{
    public function __invoke(Company $company, Vacancy $vacancy, Request $request): array
    {
        $search = $request->str('search')->toString();
        $filters = $request->query('filters');

        if ( ! is_array($filters)) {
            $filters = Arr::wrap($filters);
        }

        $filters = array_intersect($filters, ['company', 'vacancy']);

        if (empty($filters)) {
            $filters = ['company', 'vacancy'];
        }

        $results = [];

        if (in_array('company', $filters)) {
            $results['companies'] = Company::query()
                ->where('name', 'LIKE', "%{$search}%")
                ->get(array_diff($company->getFillable(), ['employer_id']))
                ->toArray();
        }

        if (in_array('vacancy', $filters)) {
            $results['vacancies'] = Vacancy::query()
                ->where('title', 'LIKE', "%{$search}%")
                ->get(array_diff($vacancy->getFillable(), ['company_id']))
                ->toArray();
        }

        return $results;
    }
}
