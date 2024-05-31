<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\CastTimestampsToDatetime;
use App\Models\Concerns\SlugAsRouteKeyName;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

final class Company extends Model implements HasMedia
{
    use CastTimestampsToDatetime;
    use HasFactory;
    use InteractsWithMedia;
    use SlugAsRouteKeyName;

    protected $fillable = [
        'code',
        'slug',
        'employer_id',
        'name',
        'description',
        'address',
        'phone',
        'link',
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function vacancies(): HasMany
    {
        return $this->hasMany(Vacancy::class);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('cover')
            ->singleFile();
    }

    protected function cover(): Attribute
    {
        return Attribute::get(
            fn() => $this
                ->getFirstMediaUrl('cover'),
        );
    }
}
