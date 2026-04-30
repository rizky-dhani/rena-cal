<?php

return [
    'label' => 'Provinsi',
    'columns' => [
        'code' => [
            'label' => 'Kode',
        ],
        'name' => [
            'label' => 'Nama',
        ],
    ],
    'forms' => [
        'code' => 'Kode Area',
        'name' => 'Nama',
    ],
    'buttons' => [
        'create' => [
            'label' => 'Buat Provinsi',
        ],
        'import' => [
            'label' => 'Impor dari API',
        ],
    ],
    'notifications' => [
        'success' => ':label berhasil dibuat',
        'import_success' => [
            'title' => 'Impor Berhasil',
            'body' => '{1}Satu provinsi berhasil diimpor.|[2,*]:count provinsi berhasil diimpor.',
        ],
        'import_error' => [
            'title' => 'Impor Gagal',
            'body' => 'Terjadi kesalahan saat mengimpor provinsi dari API.',
        ],
    ],
];
