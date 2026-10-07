<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('label')->disabled(),
                TextInput::make('key')->disabled(),
                Textarea::make('value')->rows(6)->columnSpanFull(),
            ]);
    }
}
