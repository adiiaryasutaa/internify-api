<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;

final class StoreAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Admin::class);
    }

    public function rules(): array
    {
        return [
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'name' => ['required', 'string', 'min:2', 'max:50'],
            'username' => ['required', 'string', 'min:5', 'max:20', 'unique:users,username'],
            'email' => ['required', 'email:rfc,dns', 'unique:users', 'unique:users,email'],
            'password' => ['nullable', 'min:6', 'max:20'],
        ];
    }
}
