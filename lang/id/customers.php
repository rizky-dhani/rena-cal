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
        'assign_admin' => 'Tetapkan Admin',
        'assign_admin_success' => 'Admin berhasil ditetapkan ke :label',
        'unassign_admin' => 'Hapus Penetapan Admin',
        'unassign_admin_success' => 'Penetapan Admin berhasil dihapus',
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
            'label' => 'Tipe',
        ],
        'create_new_user' => [
            'label' => 'Buat pengguna baru sebagai gantinya?',
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
        'assign' => [
            'label' => 'Tetapkan',
        ],
        'delete_user' => [
            'label' => 'Hapus akun pengguna',
            'helper_text' => 'Centang ini jika Anda ingin menghapus pengguna ini secara permanen dari sistem.',
        ],
    ],

    'sections' => [
        'details' => 'Detail Pelanggan',
        'admin' => 'Admin',
    ],
];
