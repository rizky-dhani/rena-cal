<?php

return [
    'label' => 'Perangkat',
    'plural_label' => 'Perangkat',
    'navigation_label' => 'QR Perangkat',

    'columns' => [
        'deviceId' => 'ID Perangkat',
        'device_name_id' => 'Nama Perangkat',
        'device_number' => 'Nomor Perangkat',
        'order_number' => 'Nomor Pesanan',
        'serial_number' => 'Nomor Seri',
        'room_name' => 'Nama Ruangan',
        'type_id' => 'Tipe',
        'brand_id' => 'Merek',
        'customer_id' => 'Pelanggan',
        'admin_id' => 'Admin',
        'user_id' => 'Penanggung Jawab',
        'calibration_date' => 'Tanggal Kalibrasi',
        'next_calibration_date' => 'Tanggal Kalibrasi Berikutnya',
        'status' => 'Status',
        'description' => 'Deskripsi',
        'image' => 'Gambar',
        'qr_code' => 'Kode QR',
        'created_at' => 'Dibuat pada',
        'updated_at' => 'Diperbarui pada',
        'pic_id' => 'Penanggung Jawab',
        'calibrated_date' => 'Tanggal Kalibrasi',
        'cert_number' => 'Nomor Sertifikat',
        'result' => 'Hasil',
        'procurement_year' => 'Tahun Pengadaan',
    ],

    'actions' => [
        'edit' => 'Edit',
        'delete' => 'Hapus',
        'view' => 'Lihat',
        'create' => 'Buat',
        'cancel' => 'Batal',
        'edit_success' => ':label berhasil diperbarui',
        'delete_success' => ':label berhasil dihapus',
        'delete_multiple_success' => ':label terpilih berhasil dihapus',
        'generate_empty_qr' => 'Buat Kode QR Kosong',
        'public_detail' => 'Detail Publik',
        'upload_certificate' => 'Unggah Sertifikat',
        'upload_certificate_success' => 'Sertifikat berhasil diunggah',
        'print' => 'Cetak',
        'print_tidak_laik' => 'Cetak (Tidak Laik Pakai)',
        'print_size' => [
            'label' => 'Ukuran Label',
            'placeholder' => 'Pilih ukuran label',
            'v3' => 'Normal (5x3 cm)',
            'v4' => 'Kecil (3x1.5 cm)',
        ],
    ],

    'generate' => [
        'qr_number' => 'Jumlah QR kosong',
        'qr_number_helper' => 'Masukkan jumlah QR kosong yang akan dibuat (maks 1000)',
        'invalid_number' => 'Jumlah yang dimasukkan tidak valid',
        'invalid_number_body' => 'Masukkan jumlah yang valid',
        'generate_success' => 'Kode QR berhasil dibuat',
    ],

    'detail' => [
        'qr_not_available' => 'QR Code tidak tersedia',
        'no_device_id' => 'Tidak ada ID Perangkat tersedia',
        'cal_info' => 'Informasi Kalibrasi',
        'download_certificate' => 'Unduh Sertifikat',
        'cert_not_available' => 'Sertifikat tidak tersedia',
    ],

    'form' => [
        'device_name_id' => [
            'label' => 'Nama Perangkat',
            'placeholder' => 'Pilih nama perangkat',
            'modal_heading' => 'Buat Nama Perangkat',
        ],
        'device_number' => [
            'label' => 'Nomor Perangkat',
        ],
        'order_number' => [
            'label' => 'Nomor Pesanan',
        ],
        'serial_number' => [
            'label' => 'Nomor Seri',
        ],
        'room_name' => [
            'label' => 'Nama Ruangan',
            'placeholder' => 'Masukkan nama ruangan',
        ],
        'type_id' => [
            'label' => 'Tipe',
            'placeholder' => 'Pilih tipe',
            'modal_heading' => 'Buat Tipe',
        ],
        'brand_id' => [
            'label' => 'Merek',
            'placeholder' => 'Pilih merek',
            'modal_heading' => 'Buat Merek',
        ],
        'customer_id' => [
            'label' => 'Pelanggan',
            'placeholder' => 'Pilih pelanggan',
            'modal_heading' => 'Buat Pelanggan',
        ],
        'admin_id' => [
            'label' => 'Admin',
            'placeholder' => 'Pilih admin',
        ],
        'user_id' => [
            'label' => 'Penanggung Jawab',
            'placeholder' => 'Pilih penanggung jawab',
        ],
        'calibration_date' => [
            'label' => 'Tanggal Kalibrasi',
        ],
        'next_calibration_date' => [
            'label' => 'Tanggal Kalibrasi Selanjutnya',
        ],
        'description' => [
            'label' => 'Deskripsi',
        ],
        'image' => [
            'label' => 'Gambar',
        ],
        'name' => [
            'label' => 'Nama',
        ],
        'brand' => [
            'label' => 'Merek',
        ],
        'phone_number' => [
            'label' => 'Nomor Telepon',
        ],
        'address' => [
            'label' => 'Alamat',
        ],
        'procurement_year' => [
            'label' => 'Tahun Pengadaan',
        ],
        'calibrated_date' => [
            'label' => 'Tanggal Kalibrasi',
        ],
        'result' => [
            'label' => 'Hasil',
            'options' => [
                'fit_for_use' => 'Laik Pakai',
                'not_fit_for_use' => 'Tidak Laik Pakai',
            ],
        ],
        'status' => [
            'options' => [
                'available' => 'Tersedia',
                'unavailable' => 'Tidak Tersedia',
            ],
        ],
        'cert_number' => [
            'label' => 'Nomor Sertifikat',
        ],
        'cert_password' => [
            'label' => 'Kata Sandi Sertifikat',
        ],
        'notes' => [
            'label' => 'Catatan',
            'empty' => 'Tidak ada catatan tersedia',
        ],
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
        'label' => 'Ekspor Excel',
        'type' => [
            'label' => 'Jenis Ekspor',
            'all' => 'Semua Data',
            'range' => 'Rentang Tanggal',
        ],
        'date_field' => [
            'label' => 'Kolom Tanggal',
            'calibration_date' => 'Tanggal Kalibrasi',
            'next_calibration_date' => 'Tanggal Kalibrasi Selanjutnya',
        ],
        'date_range' => 'Rentang Tanggal',
        'filename' => 'Data-Perangkat-',
    ],

    'import' => [
        'label' => 'Impor Perangkat',
        'file' => 'File Excel',
        'success' => 'Perangkat berhasil diimpor',
        'fail' => 'Impor gagal',
        'error' => 'Terjadi kesalahan saat impor',
        'template' => 'Unduh Templat',
    ],
];
