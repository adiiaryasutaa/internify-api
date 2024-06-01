<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Company;

use App\Models\Review;
use Illuminate\Foundation\Http\FormRequest;

final class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Review::class);
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
