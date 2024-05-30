<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\CastTimestampsToDatetime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Vacancy extends Model
{
    use CastTimestampsToDatetime;
    use HasFactory;

    protected $fillable = [
        'slug',
        'company_id',
        'title',
        'description',
        'location',
        'deadline',
        'active',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
