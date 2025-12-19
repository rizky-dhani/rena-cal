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
        'type' => [
            'label'=> 'Type',
        ]
    ],
];