<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\Backups\Pages\ListBackups;
use App\Models\Backup;
use App\Services\DatabaseBackupService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class BackupsResource extends Resource
{
    protected static ?string $model = Backup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CloudArrowDown;

    protected static ?string $navigationGroup = 'navigation.User Management';

    protected static ?int $navigationSort = 5;

    public static function canAccess(): bool
    {
        return Auth::user()->hasRole('Super Admin');
    }

    public static function getNavigationLabel(): string
    {
        return __('backup.navigation.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('backup.navigation.plural');
    }

    public static function getModelLabel(): string
    {
        return __('backup.navigation.singular');
    }

    public static function schema(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Infolists\Components\Section::make(__('backup.form.create_backup'))
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('info')
                            ->label(__('backup.form.create_backup_info'))
                            ->state(__('backup.form.create_backup_info_text')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('filename')
                    ->label(__('backup.table.filename'))
                    ->searchable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('file_size')
                    ->label(__('backup.table.file_size'))
                    ->formatStateUsing(fn (Backup $record) => $record->formatted_size)
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label(__('backup.table.status'))
                    ->badge()
                    ->color(fn (Backup $record) => $record->status_color)
                    ->formatStateUsing(fn (Backup $record) => $record->status_label)
                    ->searchable(),

                Tables\Columns\TextColumn::make('creator.name')
                    ->label(__('backup.table.created_by'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('backup.table.created_at'))
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('backup.table.status'))
                    ->options([
                        'pending' => __('backup.status.pending'),
                        'completed' => __('backup.status.completed'),
                        'failed' => __('backup.status.failed'),
                    ]),
            ])
            ->recordActions([
                Action::make('download')
                    ->label(__('backup.actions.download'))
                    ->icon(Heroicon::ArrowDownTray)
                    ->color('success')
                    ->visible(fn (Backup $record) => $record->status === 'completed' && $record->fileExists())
                    ->action(fn (DatabaseBackupService $service, Backup $record) => $service->download($record)),

                Action::make('restore')
                    ->label(__('backup.actions.restore'))
                    ->icon(Heroicon::ArrowPath)
                    ->color('warning')
                    ->visible(fn (Backup $record) => $record->status === 'completed' && $record->fileExists())
                    ->requiresConfirmation()
                    ->modalHeading(__('backup.restore.modal_heading'))
                    ->modalDescription(__('backup.restore.modal_description'))
                    ->modalSubmitActionLabel(__('backup.actions.restore'))
                    ->modalIcon(Heroicon::ExclamationTriangle)
                    ->action(function (DatabaseBackupService $service, Backup $record) {
                        try {
                            $service->restore($record);
                            
                            Notification::make()
                                ->title(__('backup.restore.success_title'))
                                ->body(__('backup.restore.success_body', ['filename' => $record->filename]))
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title(__('backup.restore.error_title'))
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                \Filament\Actions\DeleteAction::make()
                    ->label(__('backup.actions.delete'))
                    ->visible(fn (Backup $record) => $record->fileExists()),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Action::make('create_backup')
                    ->label(__('backup.actions.create_backup'))
                    ->icon(Heroicon::Plus)
                    ->color('primary')
                    ->requiresConfirmation()
                    ->modalHeading(__('backup.create.modal_heading'))
                    ->modalDescription(__('backup.create.modal_description'))
                    ->modalSubmitActionLabel(__('backup.actions.create_backup'))
                    ->action(function (DatabaseBackupService $service) {
                        try {
                            $service->create(Auth::id());
                            
                            Notification::make()
                                ->title(__('backup.create.success_title'))
                                ->body(__('backup.create.success_body'))
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title(__('backup.create.error_title'))
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBackups::route('/'),
        ];
    }
}
