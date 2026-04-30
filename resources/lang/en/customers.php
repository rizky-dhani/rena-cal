<?php

return [
    'label' => 'Customer',
    'plural_label' => 'Customers',
    'navigation_label' => 'Customers',
    'columns' => [
        'name' => 'Name',
        'phone_number' => 'Phone Number',
        'address' => 'Address',
    ],
    'form' => [
        'name' => [
            'label' => 'Customer Name',
        ],
        'phone_number' => [
            'label' => 'Phone Number',
        ],
        'province' => [
            'label' => 'Province',
        ],
        'categories' => [
            'label' => 'Categories',
        ],
        'type' => [
            'label' => 'Type',
            'options' => [
                'Pemerintah' => 'Government',
                'Swasta' => 'Private',
            ],
        ],
        'address' => [
            'label' => 'Address',
        ],
        'create_new_user' => [
            'label' => 'Create New User',
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
        'delete_user' => [
            'label' => 'Delete User',
            'helper_text' => 'Delete associated user',
        ],
    ],
    'actions' => [
        'view' => 'View',
        'edit' => 'Edit',
        'edit_success' => ':label edited successfully',
        'delete' => 'Delete',
        'delete_success' => ':label deleted successfully',
        'delete_multiple_success' => ':label deleted successfully',
        'create_success' => ':label created successfully',
        'assign_admin' => 'Make Admin',
        'assign_admin_success' => ':label made admin successfully',
        'unassign_admin' => 'Remove Admin',
        'unassign_admin_success' => ':label removed as admin successfully',
    ],
    'sections' => [
        'details' => 'Customer Details',
    ],
];
