<?php

return [
    'label' => 'Izin',
    'plural_label' => 'Izin',
    'navigation_label' => 'Izin',

    'columns' => [
        'name' => 'Nama',
        'guard_name' => 'Nama Penjaga',
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

    'generate' => [
        'title' => 'Buat Izin',
        'desc' => 'Sistem akan membuat izin berdasarkan model yang tersedia. Apakah anda yakin?',
        'count_success' => ' izin berhasil dibuat',
        'empty' => 'Tidak ada izin yang dibuat',
        'success' => 'Izin berhasil dibuat',
        'button_label' => 'Buat',
    ],

    'form' => [
        'name' => [
            'label' => 'Nama',
        ],
        'guard_name' => [
            'label' => 'Nama Penjaga',
            'options' => [
                'web' => 'Web',
                'api' => 'API',
            ],
        ],
    ],
];
