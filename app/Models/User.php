<?php

namespace App\Models;

use App\Enums\Role;
use App\Enums\UserStatus;
use App\Models\Concerns\CastTimestampsToDatetime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use CastTimestampsToDatetime;
    use HasApiTokens;
    use HasFactory;
    use InteractsWithMedia;
    use Notifiable;

    protected $attributes = [
        'status' => UserStatus::ACTIVE,
    ];

    protected $fillable = [
        'avatar',
        'name',
        'username',
        'email',
        'password',
        'role',
        'userable_id',
        'userable_type',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'password' => 'hashed',
            'role' => Role::class,
            'status' => UserStatus::class,
        ]);
    }

    protected function avatar(): Attribute
    {
        return Attribute::get(fn() => $this
            ->getFirstMediaUrl('avatar'),
        );
    }

    public function userable(): MorphTo
    {
        return $this->morphTo();
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(50)
                    ->height(50);
            });
    }
}
