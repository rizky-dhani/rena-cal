<?php

return [
    'label' => 'Permission',
    'plural_label' => 'Permissions',
    'navigation_label' => 'Permissions',

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

    'generate' => [
        'title' => 'Generate Permissions',
        'desc' => 'This will automatically generate permissions based on your application models and controllers. Do you want to continue?',
        'count_success' => ' permissions generated successfully',
        'empty' => 'No Permission(s) generated',
        'success' => 'Permission successfully created',
        'button_label' => 'Generate',
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
    ],
];
