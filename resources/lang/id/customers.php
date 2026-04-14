<?php

return [
    'label' => 'Pelanggan',
    'plural_label' => 'Pelanggan',
    'navigation_label' => 'Pelanggan',

    'columns' => [
        'name' => 'Nama',
        'phone_number' => 'Nomor Telepon',
        'address' => 'Alamat',
    ],

    'form' => [
        'name' => [
            'label' => 'Nama Pelanggan',
        ],
        'phone_number' => [
            'label' => 'Nomor Telepon',
        ],
        'province' => [
            'label' => 'Provinsi',
        ],
        'categories' => [
            'label' => 'Kategori',
        ],
        'type' => [
            'label' => 'Tipe',
            'options' => [
                'Pemerintah' => 'Pemerintah',
                'Swasta' => 'Swasta',
            ],
        ],
        'address' => [
            'label' => 'Alamat',
        ],
        'create_new_user' => [
            'label' => 'Buat Pengguna Baru',
        ],
        'select_user' => [
            'label' => 'Pilih Pengguna',
        ],
        'new_user_name' => [
            'label' => 'Nama Pengguna Baru',
        ],
        'new_user_email' => [
            'label' => 'Email Pengguna Baru',
        ],
        'new_user_phone' => [
            'label' => 'Telepon Pengguna Baru',
        ],
        'delete_user' => [
            'label' => 'Hapus Pengguna',
            'helper_text' => 'Hapus pengguna yang terhubung',
        ],
    ],

    'actions' => [
        'view' => 'Lihat',
        'edit' => 'Ubah',
        'edit_success' => ':label berhasil diubah',
        'delete' => 'Hapus',
        'delete_success' => ':label berhasil dihapus',
        'delete_multiple_success' => ':label berhasil dihapus',
        'create_success' => ':label berhasil dibuat',
        'assign_admin' => 'Jadikan Admin',
        'assign_admin_success' => ':label berhasil dijadikan admin',
        'unassign_admin' => 'Hapus Admin',
        'unassign_admin_success' => ':label berhasil dihapus sebagai admin',
    ],

    'sections' => [
        'details' => 'Detail Pelanggan',
    ],
];
