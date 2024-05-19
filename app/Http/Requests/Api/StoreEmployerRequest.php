<?php

namespace App\Http\Requests\Api;

use App\Models\Employer;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Employer::class);
    }

    public function rules(): array
    {
        return [
            'user' => [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'username' => ['required', 'string', 'max:20', 'unique:users,username'],
                'password' => ['required', 'string', 'min:8'],
                'photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            ],
        ];
    }
}
