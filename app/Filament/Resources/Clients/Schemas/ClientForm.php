<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                TextInput::make('url')->label('Website')->url(),
                FileUpload::make('logo')
                    ->image()
                    ->disk('public')
                    ->directory('clients')
                    ->helperText('PNG with a white or transparent background works best.'),
                TextInput::make('sort_order')->numeric()->default(0),
            ]);
    }
}
