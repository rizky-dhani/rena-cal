<?php

namespace App\Policies;

use App\Models\Device;
use App\Models\User;

class DevicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any-device') ||
               $user->hasRole(['Super Admin', 'Admin', 'Technician', 'Hospital Admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Device $device): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin', 'Technician'])) {
            return true;
        }

        // Hospital Admin can only view devices belonging to their customer
        if ($user->hasRole('Hospital Admin') && $user->customer_id === $device->customer_id) {
            return true;
        }

        return $user->can('view-device');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create-device') ||
               $user->hasRole(['Super Admin', 'Admin', 'Technician', 'Hospital Admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Device $device): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin', 'Technician'])) {
            return true;
        }

        return $user->can('update-device');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Device $device): bool
    {
        if ($user->hasRole(['Super Admin', 'Admin', 'Technician'])) {
            return true;
        }

        return $user->can('delete-device');
    }
}
