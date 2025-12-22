<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;

class CustomerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any-customer') ||
               $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Customer $customer): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            return true;
        }

        return $user->can('view-customer');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create-customer') ||
               $user->hasRole(['Super Admin', 'Admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Customer $customer): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            return true;
        }

        return $user->can('update-customer');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Customer $customer): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            return true;
        }

        return $user->can('delete-customer');
    }
}
