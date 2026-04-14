<?php

return [
    'label' => 'Pengguna',
    'plural_label' => 'Pengguna',

    'columns' => [
        'name' => 'Nama',
        'email' => 'Email',
        'initial' => 'Inisial',
        'roles' => 'Peran',
    ],

    'form' => [
        'name' => [
            'label' => 'Nama',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'initial' => [
            'label' => 'Inisial',
        ],
        'roles' => [
            'label' => 'Peran',
        ],
        'customer' => [
            'label' => 'Pelanggan',
        ],
        'import' => [
            'label' => 'Impor Pengguna',
        ],
    ],

    'actions' => [
        'reset_password' => 'Reset Kata Sandi',
        'reset_password_success' => 'Kata sandi berhasil direset',
        'edit' => 'Ubah',
        'edit_success' => ':label berhasil diubah',
        'delete' => 'Hapus',
        'delete_success' => ':label berhasil dihapus',
        'delete_multiple_success' => ':label berhasil dihapus',
        'create_success' => ':label berhasil dibuat',
        'import_helper' => 'Unggah file Excel berisi data pengguna',
        'import_file_not_found' => 'File tidak ditemukan',
        'import_success' => ':plural_label berhasil diimpor',
        'import_failed' => 'Impor gagal',
        'import_modal_desc' => 'Unggah file Excel untuk mengimpor pengguna',
        'import_modal_submit' => 'Impor Pengguna',
    ],

    'import_users' => 'Impor Pengguna',
];
