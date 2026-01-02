<?php

return [
    'label' => 'Customer',
    'plural_label' => 'Customers',
    'navigation_label' => 'Customers',

    'columns' => [
        'name' => 'Name',
        'slug' => 'Slug',
        'phone_number' => 'Phone Number',
        'address' => 'Address',
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
        'assign_admin' => 'Assign Admin',
        'assign_admin_success' => 'Admin successfully assigned to :label',
        'unassign_admin' => 'Unassign Admin',
        'unassign_admin_success' => 'Admin successfully unassigned',
    ],

    'form' => [
        'name' => [
            'label' => 'Name',
        ],
        'phone_number' => [
            'label' => 'Phone Number',
        ],
        'address' => [
            'label' => 'Address',
        ],
        'province' => [
            'label' => 'Province',
        ],
        'categories' => [
            'label' => 'Category',
        ],
        'type' => [
            'label' => 'Type',
        ],
        'create_new_user' => [
            'label' => 'Create new user instead?',
        ],
        'select_user' => [
            'label' => 'Select User',
        ],
        'new_user_name' => [
            'label' => 'New User Name',
        ],
        'new_user_email' => [
            'label' => 'New User Email',
        ],
        'new_user_phone' => [
            'label' => 'New User Phone',
        ],
        'assign' => [
            'label' => 'Assign',
        ],
        'delete_user' => [
            'label' => 'Delete user account',
            'helper_text' => 'Check this if you want to permanently delete this user from the system.',
        ],
    ],

    'sections' => [
        'details' => 'Customer Details',
        'admin' => 'Admin',
    ],
];
