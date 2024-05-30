<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Application */
final class ApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $this->loadMissing(['vacancy', 'apprentice']);

        return [
            'slug' => $this->slug,
            'vacancy' => VacancyResource::make($this->vacancy),
            'apprentice' => ApprenticeResource::make($this->apprentice),
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'resume' => $this->resume,
            'status' => $this->status->label(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
