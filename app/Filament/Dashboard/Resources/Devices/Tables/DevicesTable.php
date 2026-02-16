<?php

namespace App\Filament\Dashboard\Resources\Devices\Tables;

use App\Models\Device;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class DevicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                $user = auth()->user();

                // If the user is a Hospital Admin (Customer Admin), restrict to their customer's devices
                if ($user && $user->hasRole('Hospital Admin') && $user->customer_id) {
                    return $query->where('customer_id', $user->customer_id)->orderByDesc('device_number');
                }

                return $query->orderByDesc('device_number');
            })
            ->columns([
                TextColumn::make('device_name_id')
                    ->label(__('devices.columns.device_name_id'))
                    ->numeric()
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->deviceName?->name ?? 'N/A'),
                TextColumn::make('device_number')
                    ->label(__('devices.columns.device_number'))
                    ->searchable()
                    ->getStateUsing(fn ($record) => $record->device_number ?? 'N/A'),
                TextColumn::make('order_number')
                    ->label(__('devices.columns.order_number'))
                    ->searchable()
                    ->getStateUsing(fn ($record) => $record->order_number ?? 'N/A'),
                TextColumn::make('brand_id')
                    ->label(__('devices.columns.brand_id'))
                    ->numeric()
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->brand?->name ?? 'N/A'),
                TextColumn::make('type_id')
                    ->label(__('devices.columns.type_id'))
                    ->numeric()
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->type?->name ?? 'N/A'),
                TextColumn::make('serial_number')
                    ->label(__('devices.columns.serial_number'))
                    ->searchable()
                    ->getStateUsing(fn ($record) => $record->serial_number ?? 'N/A'),
                TextColumn::make('room_name')
                    ->label(__('devices.columns.room_name'))
                    ->searchable()
                    ->getStateUsing(fn ($record) => $record->room_name ?? 'N/A'),
                TextColumn::make('customer_id')
                    ->label(__('devices.columns.customer_id'))
                    ->numeric()
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->customer?->name ?? 'N/A'),
                TextColumn::make('calibration_date')
                    ->label(__('devices.columns.calibration_date'))
                    ->date('d F Y')
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->calibration_date ? Carbon::parse($record->calibration_date)->format('Y-m-d') : null),
                TextColumn::make('next_calibration_date')
                    ->label(__('devices.columns.next_calibration_date'))
                    ->date('d F Y')
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->next_calibration_date ? Carbon::parse($record->next_calibration_date)->format('Y-m-d') : null),
                TextColumn::make('cert_number')
                    ->label(__('devices.columns.cert_number'))
                    ->searchable()
                    ->formatStateUsing(fn ($state) => $state ? 'Lihat Sertifikat' : 'Belum Tersedia')
                    ->color(fn ($state) => $state ? 'info' : 'gray')
                    ->url(fn ($record) => $record->cert_number ? route('certificate.download', ['cert_number' => $record->cert_number, 'no_download' => 1]).'#toolbar=0' : null)
                    ->openUrlInNewTab(),
                TextColumn::make('result')
                    ->label(__('devices.columns.result'))
                    ->searchable()
                    ->getStateUsing(fn ($record) => $record->result ?? 'N/A'),
            ])
            ->filters([
                \Filament\Tables\Filters\Filter::make('filled')
                    ->label(__('devices.filters.filled.label'))
                    ->query(function ($query) {
                        return $query->whereNotNull('device_name_id')
                            ->whereNotNull('device_number')
                            ->whereNotNull('brand_id')
                            ->whereNotNull('type_id')
                            ->whereNotNull('serial_number')
                            ->whereNotNull('room_name')
                            ->whereNotNull('procurement_year')
                            ->whereNotNull('pic_id')
                            ->whereNotNull('customer_id')
                            ->whereNotNull('calibration_date')
                            ->whereNotNull('next_calibration_date')
                            ->whereNotNull('cert_number');
                    }),
                \Filament\Tables\Filters\Filter::make('empty')
                    ->label(__('devices.filters.empty.label'))
                    ->query(function ($query) {
                        return $query->whereNull('device_name_id')
                            ->whereNull('brand_id')
                            ->whereNull('type_id')
                            ->whereNull('serial_number')
                            ->whereNull('room_name')
                            ->whereNull('procurement_year')
                            ->whereNull('pic_id')
                            ->whereNull('customer_id')
                            ->whereNull('calibration_date')
                            ->whereNull('next_calibration_date')
                            ->whereNull('cert_number');
                    }),
                \Filament\Tables\Filters\Filter::make('partially_filled')
                    ->label(__('devices.filters.partially_filled.label'))
                    ->query(function ($query) {
                        return $query->where(function ($q) {
                            $q->whereNotNull('device_name_id')
                                ->orWhereNotNull('device_number')
                                ->orWhereNotNull('brand_id')
                                ->orWhereNotNull('type_id')
                                ->orWhereNotNull('serial_number')
                                ->orWhereNotNull('room_name')
                                ->orWhereNotNull('procurement_year')
                                ->orWhereNotNull('pic_id')
                                ->orWhereNotNull('customer_id')
                                ->orWhereNotNull('calibration_date')
                                ->orWhereNotNull('next_calibration_date')
                                ->orWhereNotNull('cert_number');
                        })
                            ->where(function ($q) {
                                $q->whereNull('device_name_id')
                                    ->orWhereNull('device_number')
                                    ->orWhereNull('brand_id')
                                    ->orWhereNull('type_id')
                                    ->orWhereNull('serial_number')
                                    ->orWhereNull('room_name')
                                    ->orWhereNull('procurement_year')
                                    ->orWhereNull('pic_id')
                                    ->orWhereNull('customer_id')
                                    ->orWhereNull('calibration_date')
                                    ->orWhereNull('next_calibration_date')
                                    ->orWhereNull('cert_number');
                            });
                    }),
                \Filament\Tables\Filters\Filter::make('more_than_60_days')
                    ->label(__('widgets.device_calibration_status.more_than_60_days'))
                    ->query(function ($query) {
                        return $query->whereDate('next_calibration_date', '>', now()->addDays(60));
                    }),
                \Filament\Tables\Filters\Filter::make('within_60_days')
                    ->label(__('widgets.device_calibration_status.within_60_days'))
                    ->query(function ($query) {
                        return $query->whereDate('next_calibration_date', '<=', now()->addDays(60))
                            ->whereDate('next_calibration_date', '>', now());
                    }),
                \Filament\Tables\Filters\Filter::make('overdue')
                    ->label(__('widgets.device_calibration_status.overdue'))
                    ->query(function ($query) {
                        return $query->whereDate('next_calibration_date', '<=', now());
                    }),
                SelectFilter::make('result')
                    ->label(__('devices.filters.result.label'))
                    ->options([
                        'Laik Pakai' => __('devices.form.result.options.fit_for_use'),
                        'Tidak Laik Pakai' => __('devices.form.result.options.not_fit_for_use'),
                    ]),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label(__('devices.actions.view'))
                    ->color('dark'),
                Action::make('Public View')
                    ->label(__('devices.actions.public_detail'))
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->openUrlInNewTab()
                    ->url(fn ($record) => route('devices.publicDetail', $record->deviceId)),
                Action::make('upload_certificate')
                    ->label(__('devices.actions.upload_certificate'))
                    ->icon('heroicon-o-document-arrow-up')
                    ->color('success')
                    ->visible(fn () => ! auth()->user()->hasRole('Hospital Admin'))
                    ->form([
                        FileUpload::make('cert_number')
                            ->label(__('devices.columns.cert_number'))
                            ->disk('public')
                            ->directory('')
                            ->preserveFilenames()
                            ->acceptedFileTypes(['application/pdf'])
                            ->required(),
                    ])
                    ->action(function (Device $record, array $data): void {
                        $record->update([
                            'cert_number' => $data['cert_number'],
                        ]);

                        Notification::make()
                            ->title(__('devices.actions.upload_certificate_success'))
                            ->success()
                            ->send();
                    }),
                EditAction::make()
                    ->color('info')
                    ->label(__('devices.actions.edit'))
                    ->color('info')
                    ->visible(fn () => ! auth()->user()->hasRole('Hospital Admin'))
                    ->successNotificationTitle(__('devices.actions.edit_success', ['label' => __('devices.label')])),
                DeleteAction::make()
                    ->label(__('devices.actions.delete'))
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn () => auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                    ->successNotificationTitle(__('devices.actions.delete_success', ['label' => __('devices.label')])),
            ])
            ->headerActions([
                Action::make('send_renewal_toolbar')
                    ->label(__('notifications.calibration_renewal.send_renewal_manual'))
                    ->icon('heroicon-o-envelope')
                    ->color('warning')
                    ->visible(fn ($livewire) => auth()->user()->hasAnyRole(['Super Admin', 'Admin']) &&
                        (
                            ($livewire->tableFilters['more_than_60_days']['isActive'] ?? false) ||
                            ($livewire->tableFilters['within_60_days']['isActive'] ?? false)
                        )
                    )
                    ->action(function () {
                        \Illuminate\Support\Facades\Artisan::call('app:send-calibration-renewals');

                        \Filament\Notifications\Notification::make()
                            ->title(__('notifications.calibration_renewal.send_renewal_manual_success'))
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->label(__('devices.export.label'))
                        ->exports([
                            \App\Exports\DeviceExport::make()
                                ->modifyQueryUsing(function ($query) {
                                    $user = auth()->user();

                                    if ($user && $user->hasRole('Hospital Admin') && $user->customer_id) {
                                        $query->where('customer_id', $user->customer_id);
                                    }

                                    return $query;
                                }),
                        ])
                        ->visible(fn () => auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Hospital Admin', 'Technician'])),
                    BulkAction::make('send_renewal_bulk')
                        ->label(__('notifications.calibration_renewal.send_renewal_manual'))
                        ->icon('heroicon-o-envelope')
                        ->color('warning')
                        ->visible(fn ($livewire) => auth()->user()->hasAnyRole(['Super Admin', 'Admin']) &&
                            ! ($livewire->tableFilters['more_than_60_days']['isActive'] ?? false) &&
                            ! ($livewire->tableFilters['within_60_days']['isActive'] ?? false)
                        )
                        ->action(function (\Illuminate\Support\Collection $records) {
                            $groupedDevices = $records->groupBy('customer_id');

                            foreach ($groupedDevices as $customerId => $customerDevices) {
                                if (! $customerId) {
                                    continue;
                                }

                                $admins = \App\Models\User::role('Hospital Admin')
                                    ->where('customer_id', $customerId)
                                    ->get();

                                if ($admins->isNotEmpty()) {
                                    \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\CalibrationRenewalNotification($customerDevices));
                                }
                            }

                            \Filament\Notifications\Notification::make()
                                ->title(__('notifications.calibration_renewal.send_renewal_manual_success'))
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('bulk_print_qr')
                        ->label(__('devices.actions.print'))
                        ->icon('heroicon-o-document-arrow-down')
                        ->visible(fn () => ! auth()->user()->hasRole('Hospital Admin'))
                        ->form([
                            Select::make('size')
                                ->label(__('devices.actions.print_size.label'))
                                ->placeholder(__('devices.actions.print_size.placeholder'))
                                ->options([
                                    'v3' => __('devices.actions.print_size.v3'),
                                    'v4' => __('devices.actions.print_size.v4'),
                                ])
                                ->default('v3')
                                ->required(),
                        ])
                        ->action(function ($records, array $data) {
                            $ids = $records->pluck('id')->toArray();
                            session([
                                'qr_ids' => $ids,
                                'qr_size' => $data['size'],
                            ]);

                            return redirect()->route('devices.qr-print');
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('bulk_print_qr_tidak_laik')
                        ->label(__('devices.actions.print_tidak_laik'))
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('danger')
                        ->visible(fn () => ! auth()->user()->hasRole('Hospital Admin'))
                        ->form([
                            Select::make('size')
                                ->label(__('devices.actions.print_size.label'))
                                ->placeholder(__('devices.actions.print_size.placeholder'))
                                ->options([
                                    'v3' => __('devices.actions.print_size.v3'),
                                    'v4' => __('devices.actions.print_size.v4'),
                                ])
                                ->default('v3')
                                ->required(),
                        ])
                        ->action(function ($records, array $data) {
                            $ids = $records->where('result', 'Tidak Laik Pakai')->pluck('id')->toArray();

                            if (empty($ids)) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Tidak ada perangkat dengan hasil "Tidak Laik Pakai" yang dipilih.')
                                    ->danger()
                                    ->send();

                                return;
                            }

                            session([
                                'qr_ids' => $ids,
                                'qr_size' => $data['size'],
                            ]);

                            return redirect()->route('devices.qr-print');
                        })
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make()
                        ->label(__('devices.actions.delete'))
                        ->requiresConfirmation()
                        ->visible(fn () => auth()->user()->hasAnyRole(['Super Admin', 'Admin']))
                        ->successNotificationTitle(__('devices.actions.delete_multiple_success', ['label' => __('devices.plural_label')])),
                ]),
            ]);
    }
}
