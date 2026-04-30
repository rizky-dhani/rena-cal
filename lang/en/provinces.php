<?php

return [
    'label' => 'Province',
    'columns' => [
        'code' => [
            'label' => 'Code',
        ],
        'name' => [
            'label' => 'Name',
        ],
    ],
    'forms' => [
        'code' => 'Area Code',
        'name' => 'Name',
    ],
    'buttons' => [
        'create' => [
            'label' => 'Create Province',
        ],
        'import' => [
            'label' => 'Import from API',
        ],
    ],
    'notifications' => [
        'success' => ':label successfully created',
        'import_success' => [
            'title' => 'Import Successful',
        ],
        'import_error' => [
            'title' => 'Import Failed',
            'body' => 'An error occurred while importing provinces from the API.',
        ],
    ],
];
