<?php

return [
    'label' => 'Nama Perangkat',
    'plural_label' => 'Nama Perangkat',
    'navigation_label' => 'Nama Perangkat',

    'columns' => [
        'name' => 'Nama',
        'slug' => 'Slug',
        'description' => 'Deskripsi',
        'created_at' => 'Dibuat pada',
        'updated_at' => 'Diperbarui pada',
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
        'delete_multiple_success' => ':label terpilih berhasil dihapus',
    ],

    'form' => [
        'name' => [
            'label' => 'Nama',
        ],
        'description' => [
            'label' => 'Deskripsi',
        ],
        'slug' => [
            'label' => 'Slug',
        ],
    ],
];
