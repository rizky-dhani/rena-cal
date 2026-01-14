<?php

namespace App\Filament\Dashboard\Resources\Roles\Pages;

use Filament\Infolists;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Spatie\Permission\Models\Role;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Spatie\Permission\Models\Permission;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Dashboard\Resources\Roles\RoleResource;    

class ViewRole extends ViewRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->color('info')
                ->successNotificationTitle(__('roles.actions.edit_success', ['label' => __('roles.label')])),
            Action::make('assign_permissions')
                ->label(__('roles.actions.assign_permissions'))
                ->form([
                    Select::make('permissions')
                        ->label(__('roles.form.permissions.label'))
                        ->options(function () {
                            $roleId = $this->getRecord()->id;
                            // Get all permissions that are NOT already assigned to this role
                            $assignedPermissionIds = Role::findById($roleId)->permissions()->pluck('id')->toArray();
                            $availablePermissions = Permission::whereNotIn('id', $assignedPermissionIds)->get();
                            return $availablePermissions->pluck('name', 'id');
                        })
                        ->preload()
                        ->searchable()
                        ->multiple()
                        ->createOptionUsing(function (array $data) {
                            return Permission::create($data)->id;
                        })
                        ->createOptionModalHeading(__('roles.actions.add_new_permission'))
                        ->createOptionForm([
                            TextInput::make('name')
                                ->label(__('permissions.form.name.label'))
                                ->required(),
                            Select::make('guard_name')
                                ->label(__('permissions.form.guard_name.label'))
                                ->options([
                                    'web' => 'web'
                                ])
                                ->default('web')
                                ->required(),
                        ])
                ])
                ->action(function (array $data): void {
                    $role = $this->getRecord();
                    if (isset($data['permissions']) && !empty($data['permissions'])) {
                        $role->givePermissionTo($data['permissions']);
                    }
                })
                ->color('warning')
                ->icon(Heroicon::ArrowsRightLeft)
                ->successNotificationTitle(__('roles.actions.assign_permissions_success'))
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('roles.sections.role_details'))
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('roles.columns.name')),
                        TextEntry::make('guard_name')
                            ->label(__('roles.columns.guard_name'))
                    ])
                    ->columnSpanFull(),
            ]);
    }
}