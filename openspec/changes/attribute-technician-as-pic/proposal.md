# Proposal: Attribute Technician as PIC on Device Update

This proposal implements automatic attribution of the Person In Charge (PIC) when a device record is updated by a user with the 'Technician' role.

## Problem
Currently, the `pic_id` (Person In Charge) of a device is only manually assigned or set in specific Filament table actions. When a technician performs an update via the standard edit page or other interfaces, their involvement isn't automatically recorded in the `pic_id` field. This leads to:
1. Inconsistent data in the system.
2. Missing attribution in the public device detail view.
3. Fragile role checks using `$user->role` instead of standard Spatie `hasRole()`.

## Solution
1. **Model-Level Attribution**: Add logic to the `updating` event in the `Device` model to automatically set `pic_id` to the current authenticated user's ID if they have the 'Technician' role. This ensures the change is captured regardless of which UI is used.
2. **Centralized Admin Attribution**: Similarly, ensure `admin_id` is set if the updating user is an Admin/Super Admin.
3. **Public View Verification**: Ensure `resources/views/livewire/public/device-detail.blade.php` correctly renders the PIC name from the relationship.
4. **Refactor Table Actions**: Clean up `DevicesTable.php` by removing the redundant manual attribution logic from `EditAction`.

## Scope
- `app/Models/Device.php`: Implement `updating` event logic for role-based attribution.
- `app/Filament/Dashboard/Resources/Devices/Tables/DevicesTable.php`: Remove redundant and incorrect role-check logic.
- `resources/views/livewire/public/device-detail.blade.php`: Verify display of PIC information.
