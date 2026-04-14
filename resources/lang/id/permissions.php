<?php

return [
    'label' => 'Izin',
    'plural_label' => 'Izin',
    'navigation_label' => 'Izin',

    'columns' => [
        'name' => 'Nama',
        'guard_name' => 'Penjaga',
    ],

    'form' => [
        'name' => [
            'label' => 'Nama Izin',
        ],
        'guard_name' => [
            'label' => 'Penjaga',
        ],
    ],

    'actions' => [
        'edit' => 'Ubah',
        'edit_success' => ':label berhasil diubah',
        'delete' => 'Hapus',
        'delete_success' => ':label berhasil dihapus',
        'delete_multiple_success' => ':plural_label berhasil dihapus',
    ],

    'generate' => [
        'title' => 'Buat Izin',
        'desc' => 'Buat izin baru secara otomatis',
        'button_label' => 'Buat Izin',
        'success' => 'Izin berhasil dibuat',
        'count_success' => ':count izin berhasil dibuat',
        'empty' => 'Tidak ada izin yang perlu dibuat',
    ],
];
