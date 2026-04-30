<?php

return [
    'label' => 'Tipe',
    'plural_label' => 'Tipe',
    'navigation_label' => 'Tipe',

    'columns' => [
        'name' => 'Nama',
        'slug' => 'Slug',
        'brand_id' => 'Merek',
        'description' => 'Deskripsi',
        'created_at' => 'Dibuat pada',
        'updated_at' => 'Diperbarui pada',
        'brand' => 'Merek',
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
        'create_brand_modal_heading' => 'Buat Merek',
    ],

    'form' => [
        'brand_id' => [
            'label' => 'Merek',
            'placeholder' => 'Pilih merek',
            'create_option_modal_heading' => 'Buat Merek',
        ],
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
