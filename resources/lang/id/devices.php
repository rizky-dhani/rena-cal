<?php

return [
    'label' => 'Perangkat',
    'plural_label' => 'Perangkat',
    'navigation_label' => 'Perangkat',

    'columns' => [
        'deviceId' => 'ID Perangkat',
        'device_name_id' => 'Nama Perangkat',
        'device_number' => 'Nomor Perangkat',
        'order_number' => 'Nomor Urut',
        'brand_id' => 'Merek',
        'type_id' => 'Tipe',
        'serial_number' => 'Nomor Seri',
        'room_name' => 'Nama Ruangan',
        'customer_id' => 'Pelanggan',
        'calibration_date' => 'Tanggal Kalibrasi',
        'next_calibration_date' => 'Kalibrasi Berikutnya',
        'cert_number' => 'Nomor Sertifikat',
        'result' => 'Hasil',
        'pic_id' => 'PIC',
    ],

    'form' => [
        'device_name_id' => [
            'label' => 'Nama Perangkat',
            'modal_heading' => 'Pilih Nama Perangkat',
        ],
        'name' => [
            'label' => 'Nama',
        ],
        'serial_number' => [
            'label' => 'Nomor Seri',
        ],
        'brand_id' => [
            'label' => 'Merek',
            'modal_heading' => 'Pilih Merek',
        ],
        'type_id' => [
            'label' => 'Tipe',
            'modal_heading' => 'Pilih Tipe',
        ],
        'brand' => [
            'label' => 'Merek',
        ],
        'device_number' => [
            'label' => 'Nomor Perangkat',
        ],
        'order_number' => [
            'label' => 'Nomor Urut',
        ],
        'room_name' => [
            'label' => 'Nama Ruangan',
            'placeholder' => 'Masukkan nama ruangan',
        ],
        'customer_id' => [
            'label' => 'Pelanggan',
            'modal_heading' => 'Pilih Pelanggan',
        ],
        'phone_number' => [
            'label' => 'Nomor Telepon',
        ],
        'address' => [
            'label' => 'Alamat',
        ],
        'calibration_date' => [
            'label' => 'Tanggal Kalibrasi',
        ],
        'result' => [
            'label' => 'Hasil',
            'options' => [
                'fit_for_use' => 'Laik Pakai',
                'not_fit_for_use' => 'Tidak Laik Pakai',
            ],
        ],
        'cert_number' => [
            'label' => 'Nomor Sertifikat',
        ],
        'cert_password' => [
            'label' => 'Password Sertifikat',
        ],
        'user_id' => [
            'label' => 'Pengguna',
        ],
        'next_calibration_date' => [
            'label' => 'Tanggal Kalibrasi Berikutnya',
        ],
    ],

    'actions' => [
        'view' => 'Lihat',
        'public_detail' => 'Detail Publik',
        'upload_certificate' => 'Unggah Sertifikat',
        'upload_certificate_success' => 'Sertifikat berhasil diunggah',
        'edit' => 'Ubah',
        'edit_success' => ':label berhasil diubah',
        'delete' => 'Hapus',
        'delete_success' => ':label berhasil dihapus',
        'delete_multiple_success' => ':label berhasil dihapus',
        'print' => 'Cetak',
        'print_tidak_laik' => 'Cetak Tidak Laik',
        'print_size' => [
            'label' => 'Ukuran Cetak',
            'placeholder' => 'Pilih ukuran cetak',
            'v3' => 'V3 (100mm x 150mm)',
            'v4' => 'V4 (100mm x 200mm)',
        ],
        'generate_empty_qr' => 'Generate QR Kosong',
    ],

    'filters' => [
        'filled' => [
            'label' => 'Terisi',
        ],
        'empty' => [
            'label' => 'Kosong',
        ],
        'partially_filled' => [
            'label' => 'Terisi Sebagian',
        ],
        'result' => [
            'label' => 'Hasil',
        ],
    ],

    'export' => [
        'label' => 'Ekspor Perangkat',
        'type' => [
            'label' => 'Tipe Ekspor',
            'all' => 'Semua',
            'range' => 'Rentang',
        ],
        'date_field' => [
            'label' => 'Bidang Tanggal',
            'calibration_date' => 'Tanggal Kalibrasi',
            'next_calibration_date' => 'Kalibrasi Berikutnya',
        ],
        'date_range' => 'Rentang Tanggal',
        'filename' => 'Perangkat_',
    ],

    'import' => [
        'label' => 'Impor Perangkat',
        'file' => 'File Impor',
        'success' => 'Perangkat berhasil diimpor',
        'fail' => 'Impor perangkat gagal',
        'error' => 'Terjadi kesalahan saat mengimpor',
    ],

    'generate' => [
        'qr_number' => 'Jumlah QR Code',
        'qr_number_helper' => 'Masukkan jumlah QR code yang ingin dibuat',
        'invalid_number' => 'Jumlah Tidak Valid',
        'invalid_number_body' => 'Jumlah QR code harus lebih dari 0',
        'generate_success' => 'QR code berhasil dibuat',
    ],

    'detail' => [
        'cal_info' => 'Informasi Kalibrasi',
    ],
];
