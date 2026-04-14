<?php

return [
    'label' => 'Peran',
    'plural_label' => 'Peran',
    'navigation_label' => 'Peran',

    'columns' => [
        'name' => 'Nama',
        'guard_name' => 'Penjaga',
    ],

    'form' => [
        'name' => [
            'label' => 'Nama Peran',
        ],
        'guard_name' => [
            'label' => 'Penjaga',
        ],
        'permissions' => [
            'label' => 'Izin',
        ],
    ],

    'formpermissions' => [
        'label' => 'Izin Peran',
        'helper_text' => 'Pilih izin yang diberikan kepada peran ini',
    ],

    'actions' => [
        'view' => 'Lihat',
        'edit' => 'Ubah',
        'edit_success' => ':label berhasil diubah',
        'delete' => 'Hapus',
        'delete_success' => ':label berhasil dihapus',
        'delete_multiple_success' => ':label berhasil dihapus',
        'create_success' => ':label berhasil dibuat',
        'assign_permissions' => 'Berikan Izin',
        'assign_permissions_success' => 'Izin berhasil diberikan',
        'add_new_permission' => 'Tambah Izin Baru',
    ],

    'sections' => [
        'role_details' => 'Detail Peran',
    ],
];
