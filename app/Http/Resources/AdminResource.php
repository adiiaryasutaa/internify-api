<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Admin */
final class AdminResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'slug' => $this->slug,
            'user' => UserResource::make($this->user),
            'is_owner' => $this->is_owner,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
