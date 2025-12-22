<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any-user') || $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            return true;
        }

        // Users can view their own profile
        if ($user->id === $model->id) {
            return true;
        }

        return $user->can('view-user');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create-user') || $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            return true;
        }

        // Users can update their own profile
        if ($user->id === $model->id) {
            return true;
        }

        return $user->can('update-user');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            return true;
        }

        return $user->can('delete-user');
    }

    /**
     * Determine whether the user can reset user's password.
     */
    public function resetPassword(User $user, User $model): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            return true;
        }

        return $user->can('reset-password-users');
    }
}
