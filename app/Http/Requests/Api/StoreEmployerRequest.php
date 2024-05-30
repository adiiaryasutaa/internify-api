<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Models\Employer;
use Illuminate\Foundation\Http\FormRequest;

final class StoreEmployerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Employer::class);
    }

    public function rules(): array
    {
        return [
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'username' => ['required', 'string', 'max:20', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
