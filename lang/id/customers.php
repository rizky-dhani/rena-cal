<?php

return [
    'label' => 'Pelanggan',
    'plural_label' => 'Pelanggan',
    'navigation_label' => 'Pelanggan',
    
    'columns' => [
        'name' => 'Nama',
        'slug' => 'Slug',
        'phone_number' => 'Nomor Telepon',
        'address' => 'Alamat',
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
        'phone_number' => [
            'label' => 'Nomor Telepon',
        ],
        'address' => [
            'label' => 'Alamat',
        ],
        'province' => [
            'label' => 'Provinsi',
        ],
        'categories' => [
            'label' => 'Kategori',
        ],
        'type' => [
            'label'=> 'Tipe',
        ]
    ],
];