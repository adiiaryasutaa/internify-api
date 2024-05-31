<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\CastTimestampsToDatetime;
use App\Models\Concerns\SlugAsRouteKeyName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Review extends Model
{
    use CastTimestampsToDatetime;
    use HasFactory;
    use SlugAsRouteKeyName;

    protected $fillable = [
        'code',
        'slug',
        'apprentice_id',
        'company_id',
        'summary',
        'description',
    ];

    public function apprentice(): BelongsTo
    {
        return $this->belongsTo(Apprentice::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
