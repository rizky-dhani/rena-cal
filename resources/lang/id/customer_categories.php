<?php

return [
    'label' => 'Kategori Pelanggan',
    'plural_label' => 'Kategori Pelanggan',
    'navigation_label' => 'Kategori Pelanggan',

    'columns' => [
        'name' => [
            'label' => 'Nama',
        ],
        'slug' => [
            'label' => 'Slug',
        ],
    ],

    'form' => [
        'name' => [
            'label' => 'Nama Kategori',
        ],
    ],

    'actions' => [
        'edit' => 'Ubah',
        'edit_success' => ':label berhasil diubah',
        'delete' => 'Hapus',
        'delete_success' => ':label berhasil dihapus',
        'delete_multiple_success' => ':plural_label berhasil dihapus',
        'create_success' => ':label berhasil dibuat',
    ],

    'widgets' => [
        'by_types' => [
            'heading' => 'Pelanggan Berdasarkan Tipe',
        ],
        'by_categories' => [
            'heading' => 'Pelanggan Berdasarkan Kategori',
        ],
    ],
];
