<?php

return [
    'label' => 'User',
    'plural_label' => 'Users',

    'columns' => [
        'name' => 'Name',
        'email' => 'Email',
        'initial' => 'Initial',
        'roles' => 'Roles',
    ],

    'form' => [
        'name' => [
            'label' => 'Name',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'initial' => [
            'label' => 'Initial',
        ],
        'roles' => [
            'label' => 'Roles',
        ],
        'customer' => [
            'label' => 'Customer',
        ],
        'import' => [
            'label' => 'Import Users',
        ],
    ],

    'actions' => [
        'reset_password' => 'Reset Password',
        'reset_password_success' => 'Password reset successfully',
        'edit' => 'Edit',
        'edit_success' => ':label edited successfully',
        'delete' => 'Delete',
        'delete_success' => ':label deleted successfully',
        'delete_multiple_success' => ':label deleted successfully',
        'create_success' => ':label created successfully',
        'import_helper' => 'Upload Excel file with user data',
        'import_file_not_found' => 'File not found',
        'import_success' => ':plural_label imported successfully',
        'import_failed' => 'Import failed',
        'import_modal_desc' => 'Upload Excel file to import users',
        'import_modal_submit' => 'Import Users',
    ],

    'import_users' => 'Import Users',
];
