<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

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
            'apprentice' => ['required', 'string', 'exists:apprentices,slug'],
            'company' => ['required', 'string', 'exists:companies,slug'],
            'summary' => ['required', 'string', 'min:10', 'max:30'],
            'description' => ['required', 'string', 'min:10'],
            'medias' => ['nullable', 'array', 'image', 'max:2024'],
        ];
    }
}
