<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\CastTimestampsToDatetime;
use App\Models\Concerns\SlugAsRouteKeyName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Vacancy extends Model
{
    use CastTimestampsToDatetime;
    use HasFactory;
    use SlugAsRouteKeyName;

    protected $fillable = [
        'code',
        'slug',
        'company_id',
        'category_id',
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
