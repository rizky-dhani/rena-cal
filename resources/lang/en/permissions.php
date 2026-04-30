<?php

return [
    'label' => 'Permission',
    'plural_label' => 'Permissions',
    'navigation_label' => 'Permissions',
    'columns' => [
        'name' => 'Name',
        'guard_name' => 'Guard',
    ],
    'form' => [
        'name' => [
            'label' => 'Permission Name',
        ],
        'guard_name' => [
            'label' => 'Guard',
        ],
    ],
    'actions' => [
        'edit' => 'Edit',
        'edit_success' => ':label edited successfully',
        'delete' => 'Delete',
        'delete_success' => ':label deleted successfully',
        'delete_multiple_success' => ':label deleted successfully',
    ],
    'generate' => [
        'title' => 'Generate Permissions',
        'desc' => 'Generate permissions automatically',
        'button_label' => 'Generate Permissions',
        'success' => 'Permissions generated successfully',
        'count_success' => ':count permissions generated',
        'empty' => 'No permissions to generate',
    ],
];
