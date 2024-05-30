<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\User\Contracts\CreatesUsers;
use App\Enums\Role;
use App\Models\Admin;
use App\Models\Apprentice;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

final class CreateUser implements CreatesUsers
{
    private array $fills;

    public function __construct(User $user)
    {
        $this->fills = Arr::except($user->getFillable(), ['avatar', 'role', 'userable_id', 'userable_type']);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function createAsAdmin(Admin $admin, array $inputs): User
    {
        $data = Arr::only($inputs, $this->fills);
        $data['role'] = Role::ADMIN;

        return tap(
            $admin->user()->create($data),
            fn(User $user) => $this->handleAvatar($user, Arr::get($inputs, 'avatar')),
        );
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function createAsEmployer(Employer $employer, array $inputs): User
    {
        $data = Arr::only($inputs, $this->fills);
        $data['role'] = Role::EMPLOYER;

        return tap(
            $employer->user()->create($data),
            fn(User $user) => $this->handleAvatar($user, Arr::get($inputs, 'avatar')),
        );
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function createAsApprentice(Apprentice $apprentice, array $inputs): User
    {
        $data = Arr::only($inputs, $this->fills);
        $data['role'] = Role::APPRENTICE;

        return tap(
            $apprentice->user()->create($data),
            fn(User $user) => $this->handleAvatar($user, Arr::get($inputs, 'avatar')),
        );
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function handleAvatar(User $user, ?UploadedFile $avatar): User
    {
        if ($avatar) {
            $user
                ->addMedia($avatar)
                ->toMediaCollection('avatar');
        }

        return $user;
    }
}
