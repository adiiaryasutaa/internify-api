<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->company);
    }

    public function rules(): array
    {
        return [
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'name' => ['required', 'string', 'min:10', 'max:255'],
            'description' => ['required', 'string', 'min:20'],
            'address' => ['required', 'string', 'min:10', 'max:255'],
            'phone' => ['required', 'string', 'min:10', 'max:13'],
            'link' => ['nullable', 'string', 'max:255'],
        ];
    }
}
