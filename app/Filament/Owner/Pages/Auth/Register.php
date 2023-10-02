<?php

namespace App\Filament\Owner\Pages\Auth;

use Filament\Forms\Form;
use Filament\Forms;
use Filament\Pages\Auth\Register as BaseRegisterPage;

class Register extends BaseRegisterPage
{
    public function form(Form $form): Form
    {
        return $form->schema([
            $this->getNameFormComponent(),
            $this->getEmailFormComponent(),
            Forms\Components\TextInput::make('phone')
                ->required()
                ->tel(),
            $this->getPasswordFormComponent(),
            $this->getPasswordConfirmationFormComponent()
        ])
        ->statePath('data');
    }
}
