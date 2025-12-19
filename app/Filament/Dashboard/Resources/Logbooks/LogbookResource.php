<?php

namespace App\Filament\Dashboard\Resources\Logbooks;

use App\Filament\Dashboard\Resources\Logbooks\Pages\ListLogbooks;
use App\Filament\Dashboard\Resources\Logbooks\Schemas\LogbookForm;
use App\Filament\Dashboard\Resources\Logbooks\Tables\LogbooksTable;
use App\Models\Logbook;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LogbookResource extends Resource
{
    protected static ?string $model = Logbook::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BookOpen;
    protected static bool $shouldRegisterNavigation = false; 
    public static function getModelLabel(): string
    {
        return __('logbooks.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('logbooks.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.Inventories');
    }

    public static function form(Schema $schema): Schema
    {
        return LogbookForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LogbooksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLogbooks::route('/'),
        ];
    }
}
