<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateVacancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->vacancy);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['required', 'string', 'min:50'],
            'location' => ['required', 'string', 'min:10'],
            'deadline' => ['required', 'date', 'after:today'],
            'active' => ['required', 'boolean'],
        ];
    }
}
