<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Models\Vacancy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreVacancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Vacancy::class);
    }

    public function rules(): array
    {
        return [
            'company' => [Rule::requiredIf($this->user()->role->isAdmin()), 'string', 'exists:companies,code'],
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['required', 'string', 'min:50'],
            'location' => ['required', 'string', 'min:10'],
            'deadline' => ['required', 'date', 'after:today'],
            'active' => ['required', 'boolean'],
        ];
    }
}
