<?php

return [
    'label' => 'Customer Category',
    'plural_label' => 'Customer Categories',
    'navigation_label' => 'Customer Categories',

    'columns' => [
        'name' => [
            'label' => 'Name',
        ],
        'slug' => [
            'label' => 'Slug',
        ],
    ],

    'form' => [
        'name' => [
            'label' => 'Category Name',
        ],
    ],

    'actions' => [
        'edit' => 'Edit',
        'edit_success' => ':label edited successfully',
        'delete' => 'Delete',
        'delete_success' => ':label deleted successfully',
        'delete_multiple_success' => ':plural_label deleted successfully',
        'create_success' => ':label created successfully',
    ],

    'widgets' => [
        'by_types' => [
            'heading' => 'Customers by Type',
        ],
        'by_categories' => [
            'heading' => 'Customers by Category',
        ],
    ],
];
