<?php

return [
    'label' => 'Type',
    'plural_label' => 'Types',
    'navigation_label' => 'Types',

    'columns' => [
        'name' => 'Name',
        'slug' => 'Slug',
        'brand_id' => 'Brand',
        'description' => 'Description',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
        'brand' => 'Brand',
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
        'create_brand_modal_heading' => 'Create Brand',
    ],

    'form' => [
        'brand_id' => [
            'label' => 'Brand',
            'placeholder' => 'Select brand',
            'create_option_modal_heading' => 'Create Brand',
        ],
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
