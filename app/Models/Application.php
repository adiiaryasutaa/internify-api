<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ApplicationStatus;
use App\Models\Concerns\CastTimestampsToDatetime;
use App\Models\Concerns\SlugAsRouteKeyName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

final class Application extends Model
{
    use CastTimestampsToDatetime;
    use HasFactory;
    use SlugAsRouteKeyName;

    protected $fillable = [
        'code',
        'slug',
        'vacancy_id',
        'apprentice_id',
        'name',
        'email',
        'phone',
        'resume',
        'status',
    ];

    protected $attributes = [
        'status' => ApplicationStatus::PENDING,
    ];

    public function apprentice(): BelongsTo
    {
        return $this->belongsTo(Apprentice::class);
    }

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }

    public function company(): HasOneThrough
    {
        return $this->hasOneThrough(Company::class, Vacancy::class);
    }

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'status' => ApplicationStatus::class,
        ]);
    }
}
