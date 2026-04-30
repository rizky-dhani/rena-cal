<?php

return [
    'label' => 'Customer Category',
    'plural_label' => 'Customer Categories',
    'navigation_label' => 'Categories',

    'form' => [
        'name' => [
            'label' => 'Name',
        ],
    ],

    'columns' => [
        'name' => [
            'label' => 'Name',
        ],
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

    'widgets' => [
        'by_categories' => [
            'heading' => 'Healthcare by Categories',
        ],
        'by_types' => [
            'heading' => 'By Segment',
        ],
    ],
];
