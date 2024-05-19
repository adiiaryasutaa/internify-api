<?php

namespace App\Actions\User;

use App\Actions\User\Contracts\CreatesUsers;
use App\Models\Admin;
use App\Models\Apprentice;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class CreateUser implements CreatesUsers
{
    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function create(array $inputs): User
    {
        return $this->handleAvatar(User::create(Arr::except($inputs, ['avatar'])), $inputs['avatar']);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function createForAdmin(Admin $admin, array $inputs): User
    {
        return $this->handleAvatar($admin->user()->create(Arr::except($inputs, ['avatar'])), $inputs['avatar']);
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function createForEmployer(Employer $employer, array $inputs): User
    {
        return $this->handleAvatar($employer->user()->create(Arr::except($inputs, ['avatar'])), $inputs['avatar']);
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function createForApprentice(Apprentice $apprentice, array $inputs): User
    {
        return $this->handleAvatar($apprentice->user()->create(Arr::except($inputs, ['avatar'])), $inputs['avatar']);
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function handleAvatar(User $user, UploadedFile $avatar): User
    {
        $user
            ->addMedia($avatar)
            ->toMediaCollection('avatar');

        return $user;
    }
}
