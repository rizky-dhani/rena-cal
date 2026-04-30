<?php

return [
    'label' => 'Role',
    'plural_label' => 'Roles',
    'navigation_label' => 'Roles',

    'columns' => [
        'name' => 'Name',
        'guard_name' => 'Guard Name',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
    ],

    'actions' => [
        'edit' => 'Edit',
        'delete' => 'Delete',
        'view' => 'View',
        'create' => 'Create',
        'cancel' => 'Cancel',
        'create_success' => ':label successfully created',
        'edit_success' => ':label successfully updated',
        'delete_success' => ':label successfully deleted',
        'delete_multiple_success' => 'Selected :label successfully deleted',
    ],

    'form' => [
        'name' => [
            'label' => 'Name',
        ],
        'guard_name' => [
            'label' => 'Guard Name',
            'options' => [
                'web' => 'Web',
                'api' => 'API',
            ],
        ],
        'permissions' => [
            'label' => 'Permissions',
            'helper_text' => 'Select permissions for this role',
        ],
    ],
];
