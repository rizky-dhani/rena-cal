<?php

namespace App\Policies;

use App\Models\Location;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LocationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any-location') ||
               $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Location $location): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            return true;
        }

        return $user->can('view-location');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create-location') ||
               $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Location $location): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            return true;
        }

        return $user->can('update-location');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Location $location): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            return true;
        }

        return $user->can('delete-location');
    }
}
