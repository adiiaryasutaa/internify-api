<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->role->isAdmin() && $this->user()->userable->is_owner;
    }

    public function rules(): array
    {
        return [
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'name' => ['required', 'string', 'min:2', 'max:50'],
            'username' => ['required', 'string', 'min:5', 'max:20', Rule::unique('users')->ignore($this->user()->id)],
            'email' => ['required', 'email:rfc,dns', 'unique:users', Rule::unique('users')->ignore($this->user()->id)],
            'password' => ['nullable', 'min:6', 'max:20'],
        ];
    }
}
