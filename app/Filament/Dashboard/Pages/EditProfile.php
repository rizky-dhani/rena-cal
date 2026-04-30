<?php

namespace App\Filament\Dashboard\Pages;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Dashboard;
use Filament\Schemas\Schema;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                $this->getNameFormComponent(),
                TextInput::make('initial')
                    ->label(__('users.form.initial.label')),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    public function getSavedNotificationTitle(): ?string
    {
        return __('users.actions.edit_success', ['label' => __('users.label')]);
    }

    protected function getRedirectUrl(): ?string
    {
        return Dashboard::getUrl();
    }
}
