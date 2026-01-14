<?php

return [
    'label' => 'Peran',
    'plural_label' => 'Peran',
    'navigation_label' => 'Peran',

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
        'assign_permissions' => 'Tetapkan Izin',
        'assign_permissions_success' => 'Izin terpilih berhasil ditetapkan',
        'add_new_permission' => 'Tambah Izin Baru',
    ],

    'sections' => [
        'role_details' => 'Detail Peran',
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
        'permissions' => [
            'label' => 'Izin',
            'helper_text' => 'Pilih izin untuk peran ini',
        ],
    ],
];