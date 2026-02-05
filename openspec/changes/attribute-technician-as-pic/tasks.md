# Tasks: Attribute Technician as PIC on Device Update

- [x] Implement `updating` hook in `Device.php` to set `pic_id` or `admin_id` based on user roles.
- [x] Fix incorrect `$user->role` check in `DevicesTable.php` and remove redundant manual assignment.
- [x] Ensure `device-detail.blade.php` shows the PIC name (verify existing implementation).
- [x] Add a feature test to verify that a Technician updating a device becomes the PIC.
