<?php

namespace App\Filament\Dashboard\Resources\Devices\Tables;

use Carbon\Carbon;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Torgodly\Html2Media\Actions\Html2MediaAction;

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
                TextColumn::make('procurement_year')
                    ->label(__('devices.columns.procurement_year'))
                    ->getStateUsing(fn ($record) => $record->procurement_year ?: 'N/A'),
                TextColumn::make('pic_id')
                    ->label(__('devices.columns.pic_id'))
                    ->numeric()
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->pic?->name ?? 'N/A'),
                TextColumn::make('customer_id')
                    ->label(__('devices.columns.customer_id'))
                    ->numeric()
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->customer?->name ?? 'N/A'),
                TextColumn::make('calibration_date')
                    ->label(__('devices.columns.calibration_date'))
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->calibration_date ? Carbon::parse($record->calibration_date)->format('Y-m-d') : 'N/A'),
                TextColumn::make('next_calibration_date')
                    ->label(__('devices.columns.next_calibration_date'))
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->next_calibration_date ? Carbon::parse($record->next_calibration_date)->format('Y-m-d') : 'N/A'),
                TextColumn::make('cert_number')
                    ->label(__('devices.columns.cert_number'))
                    ->searchable()
                    ->getStateUsing(fn ($record) => $record->cert_number ?? 'N/A'),
                TextColumn::make('result')
                    ->label(__('devices.columns.result'))
                    ->searchable()
                    ->formatStateUsing(fn(string $state) => __('devices.form.result.options.'.strtolower(str_replace(' ', '_', $state))))
                    ->getStateUsing(fn ($record) => $record->result ?? 'N/A'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'available' => 'success',
                        'unavailable' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state) => __('devices.form.status.options.'.strtolower($state)))
                    ->label(__('devices.columns.status'))
                    ->getStateUsing(fn ($record) => $record->status ?? 'N/A'),
                TextColumn::make('admin_id')
                    ->label(__('devices.columns.admin_id'))
                    ->numeric()
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->admin?->name ?? 'N/A'),
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
                        return $query->where(function($q) {
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
                        ->where(function($q) {
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
                EditAction::make()
                    ->color('info')
                    ->label(__('devices.actions.edit'))
                    ->color('info')
                    ->mutateFormDataUsing(function (array $data): array {
                        $user = auth()->user();

                        // Fill pic_id if user role is Technician
                        if ($user && $user->role === 'Technician') {
                            $data['pic_id'] = $user->id;
                        }

                        // Fill admin_id if user role is Admin
                        if ($user && $user->role === 'Admin') {
                            $data['admin_id'] = $user->id;
                        }

                        return $data;
                    })
                    ->successNotificationTitle(__('devices.actions.edit_success', ['label' => __('devices.label')])),
                DeleteAction::make()
                    ->label(__('devices.actions.delete'))
                    ->color( 'danger')
                    ->requiresConfirmation()
                    ->successNotificationTitle(__('devices.actions.delete_success', ['label' => __('devices.label')]))
                    ->action(function ($record) {
                        // Delete the associated QR code file if it exists
                        if ($record->barcode) {
                            Storage::disk('public')->delete($record->barcode);
                        }

                        // Delete the record from the database
                        $record->delete();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('bulk_print_qr')
                        ->label(__('devices.actions.print'))
                        ->icon('heroicon-o-document-arrow-down')->icon('heroicon-o-document-arrow-down')
                        ->action(function ($records) {
                            $ids = $records->pluck('id')->toArray();
                            session(['qr_ids' => $ids]);

                            return redirect()->route('devices.qr-print');
                        })
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make()
                        ->label(__('devices.actions.delete'))
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                // Delete the associated QR code file if it exists
                                if ($record->barcode) {
                                    Storage::disk('public')->delete($record->barcode);
                                }
                            }

                            // Delete the records from the database
                            $records->each->delete();
                        })
                        ->successNotificationTitle(__('devices.actions.delete_multiple_success', ['label' => __('devices.plural_label')])),
                ]),
            ]);
    }
}
