<?php

namespace App\Models;

use App\Models\Concerns\CastTimestampsToDatetime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vacancy extends Model
{
    use CastTimestampsToDatetime;
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'deadline',
    ];

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'deadline' => 'datetime',
        ]);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
