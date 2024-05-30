<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\User\Contracts\UpdatesUsers;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

final class UpdateUser implements UpdatesUsers
{
    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(User $user, array $inputs): bool
    {
        $this->handleAvatar($user, Arr::get($inputs, 'avatar'));

        return $user->update(Arr::except($inputs, 'avatar'));
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function handleAvatar(User $user, ?UploadedFile $avatar): User
    {
        if ($avatar) {
            $user
                ->clearMediaCollection('avatar')
                ->addMedia($avatar)
                ->toMediaCollection('avatar');
        }

        return $user;
    }
}
