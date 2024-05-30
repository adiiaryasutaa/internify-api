<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

final class ReviewPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Review $review): bool
    {
        if ($user->role->isAdmin()) {
            return true;
        }

        $user = $user->loadMissing('userable');

        if ($user->role->isEmployer()) {
            $review = $review->loadMissing('company.employer');

            return $review->company->employer->is($user->userable);
        }

        $review = $review->loadMissing('apprentice');

        return $review->apprentice->is($user->userable);
    }

    public function create(User $user): bool
    {
        return $user->role->is(['admin', 'apprentice']);
    }

    public function update(User $user, Review $review): bool
    {
        if ($user->role->isAdmin()) {
            return true;
        }

        if ($user->role->isApprentice()) {
            $user = $user->loadMissing('userable');
            $review = $review->loadMissing('apprentice');

            return $review->apprentice->is($user->userable) && $review->created_at?->lte(now()->addDay());
        }

        return false;
    }

    public function delete(User $user, Review $review): bool
    {
        return $this->update($user, $review);
    }

    public function restore(User $user, Review $review): bool
    {
        return $user->role->isAdmin();
    }

    public function forceDelete(User $user, Review $review): bool
    {
        return false;
    }
}
