<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Apprentice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Apprentice */
final class ApprenticeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'slug' => $this->slug,
            'user' => UserResource::make($this->user),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
