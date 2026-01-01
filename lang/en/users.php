<?php

return [
    'label' => 'User',
    'plural_label' => 'Users',
    'navigation_label' => 'Users',
    'import_users' => 'Import Users',

    'columns' => [
        'userId' => 'User ID',
        'name' => 'Name',
        'email' => 'Email',
        'initial' => 'Initial',
        'customer_id' => 'Customer',
        'email_verified_at' => 'Email Verified At',
        'password' => 'Password',
        'remember_token' => 'Remember Token',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
        'roles' => 'Roles',
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
        'reset_password' => 'Reset Password',
        'reset_password_success' => 'Password has been reset successfully',
        'import_success' => ':plural_label successfully imported',
        'import_failed' => 'Import failed',
        'import_helper' => 'Upload an Excel file (.xlsx, .csv) containing users to import. The file should have columns: name, email (password will be automatically generated)',
        'import_file_not_found' => 'File does not exist',
        'import_modal_desc' => 'Upload an Excel file to import users',
        'import_modal_submit' => 'Import',
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
        'customer_id' => [
            'label' => 'Customer',
            'placeholder' => 'Select customer',
        ],
        'password' => [
            'label' => 'Password',
        ],
        'roles' => [
            'label' => 'Roles',
        ],
        'import' => [
            'label' => 'Excel file',
        ],
        'customer' => [
            'label' => 'Customer',
        ],
    ],
];
