<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->review);
    }

    public function rules(): array
    {
        return [
            'summary' => ['required', 'string', 'min:10', 'max:30'],
            'description' => ['required', 'string', 'min:10'],
            'medias' => ['nullable', 'array', 'image', 'max:2024'],
        ];
    }
}
