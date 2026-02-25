<?php

namespace App\Filament\Dashboard\Resources\Devices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
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
                    ->columnSpanFull(),
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
                TextInput::make('device_number')
                    ->label(__('devices.form.device_number.label'))
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('order_number')
                    ->label(__('devices.form.order_number.label'))
                    ->default(null),
                TextInput::make('room_name')
                    ->label(__('devices.form.room_name.label'))
                    ->placeholder(__('devices.form.room_name.placeholder')),
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
                DatePicker::make('calibration_date')
                    ->label(__('devices.form.calibration_date.label'))
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->format('Y-m-d')
                    ->closeOnDateSelection(),
                Select::make('result')
                    ->label(__('devices.form.result.label'))
                    ->options([
                        'Laik Pakai' => 'Laik Pakai',
                        'Tidak Laik Pakai' => 'Tidak Laik Pakai',
                    ]),
                FileUpload::make('cert_number')
                    ->label(__('devices.form.cert_number.label'))
                    ->disk('public')
                    ->directory('certificates')
                    ->acceptedFileTypes(['application/pdf'])
                    ->storeFileNamesIn('original_filename')
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file, $record): string => 'CERT-'.$record->device_number.'.'.$file->getClientOriginalExtension()
                    )
                    ->columnSpanFull(),
                TextInput::make('cert_password')
                    ->label(__('devices.form.cert_password.label'))
                    ->password()
                    ->revealable()
                    ->nullable(),
            ]);
    }
}
