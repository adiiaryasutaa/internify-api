<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Models\Application;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Application::class);
    }

    public function rules(): array
    {
        return [
            'vacancy' => [Rule::requiredIf($this->user()->role->isAdmin()), 'string', 'exists:vacancies,code'],
            'apprentice' => [Rule::requiredIf($this->user()->role->isAdmin()), 'string', 'exists:apprentices,code'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'numeric', 'min_digits:10', 'max_digits:13'],
            'resume' => ['required', 'string', 'min:20'],
        ];
    }
}
