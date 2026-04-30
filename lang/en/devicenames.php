<?php

return [
    'label' => 'Device Name',
    'plural_label' => 'Device Names',
    'navigation_label' => 'Device Names',

    'columns' => [
        'name' => 'Name',
        'slug' => 'Slug',
        'description' => 'Description',
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
        'description' => [
            'label' => 'Description',
        ],
        'slug' => [
            'label' => 'Slug',
        ],
    ],
];
