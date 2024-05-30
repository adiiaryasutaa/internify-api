<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

final class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Company::class);
    }

    public function rules(): array
    {
        return [
            'employer' => ['required', 'string', 'exists:employers,slug'],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'name' => ['required', 'string', 'min:6', 'max:255'],
            'description' => ['required', 'string', 'min:20'],
            'address' => ['required', 'string', 'min:10', 'max:255'],
            'phone' => ['required', 'string', 'min:10', 'max:13'],
            'link' => ['nullable', 'string', 'max:255'],
        ];
    }
}
