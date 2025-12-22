<?php

namespace App\Policies;

use App\Models\Brand;
use App\Models\User;

class BrandPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any-brand') ||
               $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Brand $brand): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            return true;
        }

        return $user->can('view-brand');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create-brand') ||
               $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Brand $brand): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            return true;
        }

        return $user->can('update-brand');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Brand $brand): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            return true;
        }

        return $user->can('delete-brand');
    }
}
