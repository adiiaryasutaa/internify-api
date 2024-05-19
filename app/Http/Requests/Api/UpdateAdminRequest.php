<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->role->isAdmin() && $this->user()->is_owner;
    }

    public function rules(): array
    {
        return [
            'user' => [
                'name' => ['required', 'string', 'min:2', 'min:50'],
                'username' => ['required', 'string', 'min:5', 'max:20', 'unique:users,username'],
                'email' => ['required', 'email:rfc,dns', 'unique:users,email'],
                'password' => ['required', 'min:6', 'max:20'],
            ],
        ];
    }
}
