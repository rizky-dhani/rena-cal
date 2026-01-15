<?php

namespace App\Exports;

use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class DeviceExport extends ExcelExport
{
    public function setUp(): void
    {
        $this->withFilename(__('devices.export.filename').now()->format('dmY'));

        $this->withColumns([
            Column::make('deviceId')
                ->heading(__('devices.columns.deviceId')),
            Column::make('device_number')
                ->heading(__('devices.columns.device_number')),
            Column::make('deviceName.name')
                ->heading(__('devices.columns.device_name_id')),
            Column::make('serial_number')
                ->heading(__('devices.columns.serial_number')),
            Column::make('brand.name')
                ->heading(__('devices.columns.brand_id')),
            Column::make('type.name')
                ->heading(__('devices.columns.type_id')),
            Column::make('calibration_date')
                ->heading(__('devices.columns.calibration_date')),
            Column::make('next_calibration_date')
                ->heading(__('devices.columns.next_calibration_date')),
            Column::make('cert_number')
                ->heading(__('devices.columns.cert_number')),
            Column::make('result')
                ->heading(__('devices.columns.result'))
                ->formatStateUsing(fn ($state) => $state ? __('devices.form.result.options.'.$state) : ''),
            Column::make('customer.name')
                ->heading(__('devices.columns.customer_id')),
            Column::make('room_name')
                ->heading(__('devices.columns.room_name')),
            Column::make('pic.name')
                ->heading(__('devices.columns.pic_id')),
        ]);
    }
}
