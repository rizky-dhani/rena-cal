<?php

return [
    'navigation' => [
        'label' => 'Backup Database',
        'singular' => 'Backup',
        'plural' => 'Backup Database',
    ],

    'status' => [
        'pending' => 'Menunggu',
        'completed' => 'Selesai',
        'failed' => 'Gagal',
    ],

    'table' => [
        'filename' => 'Nama File',
        'file_size' => 'Ukuran File',
        'status' => 'Status',
        'created_by' => 'Dibuat Oleh',
        'created_at' => 'Tanggal Dibuat',
    ],

    'actions' => [
        'create_backup' => 'Buat Backup',
        'download' => 'Unduh',
        'restore' => 'Pulihkan',
        'delete' => 'Hapus',
    ],

    'create' => [
        'modal_heading' => 'Buat Backup Database',
        'modal_description' => 'Ini akan membuat backup terkompresi dari seluruh database. Proses mungkin memerlukan beberapa menit tergantung ukuran database.',
        'success_title' => 'Backup Dibuat',
        'success_body' => 'Backup database berhasil dibuat.',
        'error_title' => 'Backup Gagal',
    ],

    'restore' => [
        'modal_heading' => 'Pulihkan Database',
        'modal_description' => 'PERINGATAN: Ini akan mengganti database saat ini dengan backup. Semua data yang dibuat setelah backup ini akan hilang. Tindakan ini tidak dapat dibatalkan.',
        'success_title' => 'Database Dipulihkan',
        'success_body' => 'Database berhasil dipulihkan dari :filename. Harap hapus cache aplikasi jika diperlukan.',
        'error_title' => 'Pemulihan Gagal',
    ],

    'form' => [
        'create_backup' => 'Buat Backup Baru',
        'create_backup_info' => 'Informasi Backup',
        'create_backup_info_text' => 'Backup database memungkinkan Anda menyimpan snapshot data dan memulihkannya jika diperlukan. Backup dikompresi untuk menghemat ruang penyimpanan.',
    ],

    'widgets' => [
        'total_backups' => 'Total Backup',
        'total_backups_desc' => 'Jumlah file backup',
        'disk_usage' => 'Penggunaan Disk',
        'disk_usage_desc' => 'Total penyimpanan yang digunakan',
    ],
];
