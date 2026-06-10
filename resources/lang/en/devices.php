<?php

return [
    'label' => 'Device',
    'plural_label' => 'Devices',
    'navigation_label' => 'Devices',

    'columns' => [
        'deviceId' => 'Device ID',
        'device_name_id' => 'Device Name',
        'device_number' => 'Device Number',
        'order_number' => 'Order Number',
        'brand_id' => 'Brand',
        'type_id' => 'Type',
        'serial_number' => 'Serial Number',
        'room_name' => 'Room Name',
        'customer_id' => 'Customer',
        'calibration_date' => 'Calibration Date',
        'next_calibration_date' => 'Next Calibration Date',
        'cert_number' => 'Certificate Number',
        'result' => 'Result',
        'pic_id' => 'PIC',
    ],

    'form' => [
        'device_name_id' => [
            'label' => 'Device Name',
            'modal_heading' => 'Select Device Name',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'serial_number' => [
            'label' => 'Serial Number',
        ],
        'brand_id' => [
            'label' => 'Brand',
            'modal_heading' => 'Select Brand',
        ],
        'type_id' => [
            'label' => 'Type',
            'modal_heading' => 'Select Type',
        ],
        'brand' => [
            'label' => 'Brand',
        ],
        'device_number' => [
            'label' => 'Device Number',
        ],
        'order_number' => [
            'label' => 'Order Number',
        ],
        'room_name' => [
            'label' => 'Room Name',
            'placeholder' => 'Enter room name',
        ],
        'customer_id' => [
            'label' => 'Customer',
            'modal_heading' => 'Select Customer',
        ],
        'phone_number' => [
            'label' => 'Phone Number',
        ],
        'address' => [
            'label' => 'Address',
        ],
        'calibration_date' => [
            'label' => 'Calibration Date',
        ],
        'result' => [
            'label' => 'Result',
            'options' => [
                'fit_for_use' => 'Fit for Use',
                'not_fit_for_use' => 'Not Fit for Use',
            ],
        ],
        'cert_number' => [
            'label' => 'Certificate Number',
        ],
        'cert_password' => [
            'label' => 'Certificate Password',
        ],
        'user_id' => [
            'label' => 'User',
        ],
        'next_calibration_date' => [
            'label' => 'Next Calibration Date',
        ],
    ],

    'actions' => [
        'view' => 'View',
        'public_detail' => 'Public Detail',
        'upload_certificate' => 'Upload Certificate',
        'upload_certificate_success' => 'Certificate uploaded successfully',
        'edit' => 'Edit',
        'edit_success' => ':label edited successfully',
        'delete' => 'Delete',
        'delete_success' => ':label deleted successfully',
        'delete_multiple_success' => ':label deleted successfully',
        'print' => 'Print',
        'print_tidak_laik' => 'Print Not Fit',
        'print_size' => [
            'label' => 'Print Size',
            'placeholder' => 'Select print size',
            'v3' => 'V3 (100mm x 150mm)',
            'v4' => 'V4 (100mm x 200mm)',
        ],
        'page_size' => [
            'label' => 'Page Size',
            'placeholder' => 'Select page size',
            'A3' => 'A3',
            'A4' => 'A4',
            'A5' => 'A5',
        ],
        'generate_empty_qr' => 'Generate Empty QR',
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
        'result' => [
            'label' => 'Result',
        ],
    ],

    'export' => [
        'label' => 'Export Devices',
        'type' => [
            'label' => 'Export Type',
            'all' => 'All',
            'range' => 'Range',
        ],
        'date_field' => [
            'label' => 'Date Field',
            'calibration_date' => 'Calibration Date',
            'next_calibration_date' => 'Next Calibration Date',
        ],
        'date_range' => 'Date Range',
        'filename' => 'Devices_',
    ],

    'import' => [
        'label' => 'Import Devices',
        'file' => 'Import File',
        'success' => 'Devices imported successfully',
        'fail' => 'Device import failed',
        'error' => 'Error importing devices',
    ],

    'generate' => [
        'qr_number' => 'Number of QR Codes',
        'qr_number_helper' => 'Enter the number of QR codes to generate',
        'invalid_number' => 'Invalid Number',
        'invalid_number_body' => 'Number of QR codes must be greater than 0',
        'generate_success' => 'QR codes generated successfully',
    ],

    'detail' => [
        'cal_info' => 'Calibration Information',
    ],
];
