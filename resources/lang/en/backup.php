<?php

return [
    'navigation' => [
        'label' => 'Database Backups',
        'singular' => 'Backup',
        'plural' => 'Backups',
    ],

    'status' => [
        'pending' => 'Pending',
        'completed' => 'Completed',
        'failed' => 'Failed',
    ],

    'table' => [
        'filename' => 'Filename',
        'file_size' => 'File Size',
        'status' => 'Status',
        'created_by' => 'Created By',
        'created_at' => 'Created At',
    ],

    'actions' => [
        'create_backup' => 'Create Backup',
        'download' => 'Download',
        'restore' => 'Restore',
        'delete' => 'Delete',
    ],

    'create' => [
        'modal_heading' => 'Create Database Backup',
        'modal_description' => 'This will create a compressed backup of the entire database. The process may take several minutes depending on database size.',
        'success_title' => 'Backup Created',
        'success_body' => 'Database backup has been created successfully.',
        'error_title' => 'Backup Failed',
    ],

    'restore' => [
        'modal_heading' => 'Restore Database',
        'modal_description' => 'WARNING: This will replace the current database with the backup. All data created after this backup will be lost. This action cannot be undone.',
        'success_title' => 'Database Restored',
        'success_body' => 'Database has been restored from :filename. Please clear application cache if needed.',
        'error_title' => 'Restore Failed',
    ],

    'form' => [
        'create_backup' => 'Create New Backup',
        'create_backup_info' => 'Backup Information',
        'create_backup_info_text' => 'Database backups allow you to save snapshots of your data and restore them if needed. Backups are compressed to save storage space.',
    ],

    'widgets' => [
        'total_backups' => 'Total Backups',
        'total_backups_desc' => 'Number of backup files',
        'disk_usage' => 'Disk Usage',
        'disk_usage_desc' => 'Total storage used',
    ],
];
