<?php

return [
    'label' => 'Device',
    'plural_label' => 'Devices',
    'navigation_label' => 'QR Devices',

    'columns' => [
        'deviceId' => 'Device ID',
        'device_name_id' => 'Device Name',
        'device_number' => 'Device Number',
        'order_number' => 'Order Number',
        'serial_number' => 'Serial Number',
        'room_name' => 'Room Name',
        'type_id' => 'Type',
        'brand_id' => 'Brand',
        'customer_id' => 'Customer',
        'admin_id' => 'Admin',
        'user_id' => 'PIC',
        'calibration_date' => 'Calibration Date',
        'next_calibration_date' => 'Next Calibration Date',
        'status' => 'Status',
        'description' => 'Description',
        'image' => 'Image',
        'qr_code' => 'QR Code',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
        'pic_id' => 'PIC',
        'calibrated_date' => 'Calibrated Date',
        'cert_number' => 'Certificate Number',
        'result' => 'Result',
        'procurement_year' => 'Procurement Year',
    ],

    'actions' => [
        'edit' => 'Edit',
        'delete' => 'Delete',
        'view' => 'View',
        'create' => 'Create',
        'cancel' => 'Cancel',
        'edit_success' => ':label successfully updated',
        'delete_success' => ':label successfully deleted',
        'delete_multiple_success' => 'Selected :label successfully deleted',
        'generate_empty_qr' => 'Generate Empty QR Codes',
        'public_detail' => 'Public Detail',
    ],

    'generate' => [
        'qr_number' => 'Number of Empty QR Codes',
        'qr_number_helper' => 'Enter how many empty QR codes to generate',
        'invalid_number' => 'Invalid number of devices',
        'invalid_number_body' => 'Please enter a valid number of devices',
        'generate_success' => 'QR Code successfully generated',
    ],

    'detail' => [
        'qr_not_available' => 'QR Code not available',
        'no_device_id' => 'No Device ID available',
        'cal_info' => 'Calibration Information',
        'download_certificate' => 'Download Certificate',
        'cert_not_available' => 'Certificate not available',
    ],

    'form' => [
        'device_name_id' => [
            'label' => 'Device Name',
            'placeholder' => 'Select device name',
            'modal_heading' => 'Create Device Name',
        ],
        'device_number' => [
            'label' => 'Device Number',
        ],
        'order_number' => [
            'label' => 'Order Number',
        ],
        'serial_number' => [
            'label' => 'Serial Number',
        ],
        'room_name' => [
            'label' => 'Room Name',
            'placeholder' => 'Enter room name',
        ],
        'type_id' => [
            'label' => 'Type',
            'placeholder' => 'Select type',
            'modal_heading' => 'Create Type',
        ],
        'brand_id' => [
            'label' => 'Brand',
            'placeholder' => 'Select brand',
            'modal_heading' => 'Create Brand',
        ],
        'customer_id' => [
            'label' => 'Customer',
            'placeholder' => 'Select customer',
            'modal_heading' => 'Create Customer',
        ],
        'admin_id' => [
            'label' => 'Admin',
            'placeholder' => 'Select admin',
        ],
        'user_id' => [
            'label' => 'PIC',
            'placeholder' => 'Select PIC',
        ],
        'calibration_date' => [
            'label' => 'Calibration Date',
        ],
        'next_calibration_date' => [
            'label' => 'Next Calibration Date',
        ],
        'description' => [
            'label' => 'Description',
        ],
        'image' => [
            'label' => 'Image',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'brand' => [
            'label' => 'Brand',
        ],
        'phone_number' => [
            'label' => 'Phone Number',
        ],
        'address' => [
            'label' => 'Address',
        ],
        'procurement_year' => [
            'label' => 'Procurement Year',
        ],
        'calibrated_date' => [
            'label' => 'Calibrated Date',
        ],
        'result' => [
            'label' => 'Result',
            'options' => [
                'fit_for_use' => 'Fit For Use',
                'not_fit_for_use' => 'Not Fit For Use',
            ],
        ],
        'status' => [
            'label' => 'Status',
            'options' => [
                'available' => 'Available',
                'unavailable' => 'Unavailable',
            ],
        ],
        'cert_number' => [
            'label' => 'Certificate Number',
        ],
        'notes' => [
            'label' => 'Notes',
            'empty' => 'No notes available',
        ],
    ],

    'filters' => [
        'filled' => [
            'label' => 'Filled',
        ],
        'empty' => [
            'label' => 'Empty',
        ],
        'partially_filled' => [
            'label' => 'Partially Filled',
        ],
    ],

    'export' => [
        'label' => 'Export Excel',
        'type' => [
            'label' => 'Export Type',
            'all' => 'All Records',
            'range' => 'Date Range',
        ],
        'date_field' => [
            'label' => 'Date Field',
            'calibration_date' => 'Calibration Date',
            'next_calibration_date' => 'Next Calibration Date',
        ],
        'date_range' => 'Date Range',
        'filename' => 'Device-Data-',
    ],

    'import' => [
        'label' => 'Import Devices',
        'file' => 'Excel File',
        'success' => 'Devices imported successfully',
        'fail' => 'Import failed',
        'error' => 'An error occurred during import',
        'template' => 'Download Template',
    ],
];
