<?php

return [
    'label' => 'Provinsi',
    'plural_label' => 'Provinsi',
    'navigation_label' => 'Provinsi',

    'columns' => [
        'code' => [
            'label' => 'Kode',
        ],
        'name' => [
            'label' => 'Nama',
        ],
    ],

    'form' => [
        'name' => [
            'label' => 'Nama Provinsi',
        ],
    ],

    'buttons' => [
        'import' => [
            'label' => 'Impor Provinsi',
        ],
        'create' => [
            'label' => 'Buat Provinsi',
        ],
    ],

    'notifications' => [
        'success' => ':label berhasil diubah',
        'import_success' => [
            'title' => 'Impor Berhasil',
        ],
        'import_error' => [
            'title' => 'Impor Gagal',
            'body' => 'Terjadi kesalahan saat mengimpor provinsi',
        ],
    ],
];
