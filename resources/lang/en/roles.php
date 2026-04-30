<?php

return [
    'label' => 'Role',
    'plural_label' => 'Roles',
    'navigation_label' => 'Roles',
    'columns' => [
        'name' => 'Name',
        'guard_name' => 'Guard',
    ],
    'form' => [
        'name' => [
            'label' => 'Role Name',
        ],
        'guard_name' => [
            'label' => 'Guard',
        ],
        'permissions' => [
            'label' => 'Permissions',
        ],
    ],
    'formpermissions' => [
        'label' => 'Role Permissions',
        'helper_text' => 'Select permissions for this role',
    ],
    'actions' => [
        'view' => 'View',
        'edit' => 'Edit',
        'edit_success' => ':label edited successfully',
        'delete' => 'Delete',
        'delete_success' => ':label deleted successfully',
        'delete_multiple_success' => ':label deleted successfully',
        'create_success' => ':label created successfully',
        'assign_permissions' => 'Assign Permissions',
        'assign_permissions_success' => 'Permissions assigned successfully',
        'add_new_permission' => 'Add New Permission',
    ],
    'sections' => [
        'role_details' => 'Role Details',
    ],
];
