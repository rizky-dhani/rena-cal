<?php

namespace App\Filament\Dashboard\Resources\Devices\Schemas;

use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class DeviceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('device_name_id')
                    ->label(__('devices.form.device_name_id.label'))
                    ->relationship('deviceName', 'name')
                    ->preload()
                    ->searchable()
                    ->createOptionModalHeading(__('devices.form.device_name_id.modal_heading'))
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label(__('devices.form.name.label'))
                            ->columnSpanFull()
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->required(),
                Grid::make(3)
                    ->schema([
                        TextInput::make('serial_number')
                            ->label(__('devices.form.serial_number.label'))
                            ->default(null),
                        Select::make('brand_id')
                            ->label(__('devices.form.brand_id.label'))
                            ->relationship('brand', 'name')
                            ->preload()
                            ->searchable()
                            ->createOptionModalHeading(__('devices.form.brand_id.modal_heading'))
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label(__('devices.form.name.label'))
                                    ->columnSpanFull()
                                    ->required(),
                            ])
                            ->default(null),
                        Select::make('type_id')
                            ->label(__('devices.form.type_id.label'))
                            ->relationship('type', 'name')
                            ->preload()
                            ->searchable()
                            ->createOptionModalHeading(__('devices.form.type_id.modal_heading'))
                            ->createOptionForm([
                                Select::make('brand_id')
                                    ->label(__('devices.form.brand.label'))
                                    ->relationship('brand', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                TextInput::make('name')
                                    ->label(__('devices.form.name.label'))
                                    ->required(),
                            ]),
                        ])
                        ->columnSpanFull(),
                Select::make('location_id')
                    ->label(__('devices.form.location_id.label'))
                    ->relationship('location', 'name')
                    ->preload()
                    ->searchable()
                    ->createOptionModalHeading(__('devices.form.location_id.modal_heading'))
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label(__('devices.form.name.label'))
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Select::make('customer_id')
                    ->label(__('devices.form.customer_id.label'))
                    ->relationship('customer', 'name')
                    ->preload()
                    ->searchable()
                    ->createOptionModalHeading(__('devices.form.customer_id.modal_heading'))
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label(__('devices.form.name.label'))
                            ->required(),
                        TextInput::make('phone_number')
                            ->label(__('devices.form.phone_number.label'))
                            ->tel()
                            ->required()
                            ->default(null),
                        Textarea::make('address')
                            ->label(__('devices.form.address.label'))
                            ->default(null)
                            ->columnSpanFull(),
                    ]),
                TextInput::make('procurement_year')
                    ->label(__('devices.form.procurement_year.label'))
                    ->default(null),
                DatePicker::make('calibrated_date')
                    ->label(__('devices.form.calibrated_date.label'))
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->format('Y-m-d')
                    ->closeOnDateSelection(),
                Select::make('result')
                    ->label(__('devices.form.result.label'))
                    ->options([
                        'Fit For Use' => __('devices.form.result.options.fit_for_use'),
                        'Not Fit For Use' => __('devices.form.result.options.not_fit_for_use'),
                    ]),
                Select::make('status')
                    ->label(__('devices.form.status.label'))
                    ->options([
                        'Available' => __('devices.form.status.options.available'),
                        'Unavailable' => __('devices.form.status.options.unavailable'),
                    ])
                    ->default('Available')
                    ->required(),
                FileUpload::make('cert_number')
                    ->label(__('devices.form.cert_number.label'))
                    ->disk('public')
                    ->directory('certificates')
                    ->acceptedFileTypes(['application/pdf'])
                    ->storeFileNamesIn('original_filename')
                    ->getUploadedFileNameForStorageUsing(
                        fn(TemporaryUploadedFile $file, $record): string => 'CERT-' . $record->device_number . '.' . $file->getClientOriginalExtension()
                    )
                    ->columnSpanFull(),
            ]);
    }
}
