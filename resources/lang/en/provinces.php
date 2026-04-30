<?php

return [
    'label' => 'Province',
    'plural_label' => 'Provinces',
    'navigation_label' => 'Provinces',
    'columns' => [
        'code' => [
            'label' => 'Code',
        ],
        'name' => [
            'label' => 'Name',
        ],
    ],
    'buttons' => [
        'import' => [
            'label' => 'Import Provinces',
        ],
        'create' => [
            'label' => 'Create Province',
        ],
    ],
    'notifications' => [
        'success' => ':label updated successfully',
        'import_success' => [
            'title' => 'Import Successful',
        ],
        'import_error' => [
            'title' => 'Import Failed',
            'body' => 'Error importing provinces',
        ],
    ],
];
