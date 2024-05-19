<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->employer);
    }

    public function rules(): array
    {
        return [
            'user' => [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'.$this->user()->id],
                'username' => ['required', 'string', 'max:20', 'unique:users,username'.$this->user()->id],
                'password' => ['nullable', 'string', 'min:8'],
                'photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            ],
        ];
    }
}
