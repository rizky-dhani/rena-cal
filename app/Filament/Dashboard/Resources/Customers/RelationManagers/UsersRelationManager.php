<?php

namespace App\Filament\Dashboard\Resources\Customers\RelationManagers;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Password;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Dashboard\Resources\Customers\Actions\AssignAdminAction;
use App\Filament\Dashboard\Resources\Customers\Actions\UnassignAdminAction;
use App\Filament\Dashboard\Resources\Users\UserResource;
use Filament\Resources\RelationManagers\RelationManager;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $title = 'Admin';

    protected static ?string $relatedResource = UserResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->modifyQueryUsing(fn (Builder $query) => $query->role('Hospital Admin'))
            ->columns([
                TextColumn::make('name')
                    ->label(__('customers.form.name.label'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('customers.form.new_user_email.label'))
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->label(__('customers.form.phone_number.label')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AssignAdminAction::make(),
            ])
            ->actions([
                EditAction::make(),
                UnassignAdminAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }
}
