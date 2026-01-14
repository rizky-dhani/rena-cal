<?php

return [
    'label' => 'Kategori Pelanggan',
    'plural_label' => 'Kategori Pelanggan',
    'navigation_label' => 'Kategori',

    'form' => [
        'name' => [
            'label' => 'Nama'
        ]
    ],

    'columns' => [
        'name' => [
            'label'=> 'Nama'
        ],
        'slug' => [
            'label'=> 'Slug'
        ]
    ],

    'actions' => [
        'edit' => 'Edit',
        'delete' => 'Hapus',
        'view' => 'Lihat',
        'create' => 'Buat',
        'cancel' => 'Batal',
        'create_success' => ':label berhasil dibuat',
        'edit_success' => ':label berhasil diperbarui',
        'delete_success' => ':label berhasil dihapus',
        'delete_multiple_success' => ':label terpilih berhasil dihapus'
    ],

    'widgets' => [
        'by_categories' => [
            'heading' => 'Kategori Faskes'
        ],
        'by_types' => [
            'heading' => 'Segmen'
        ]
    ]
];