<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'slug',
        'name',
    ];

    public function vacancies(): HasMany
    {
        return $this->hasMany(Vacancy::class);
    }
}
