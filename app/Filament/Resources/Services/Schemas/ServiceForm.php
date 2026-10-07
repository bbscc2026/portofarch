<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required(),
                TextInput::make('sort_order')->numeric()->default(0),
                Textarea::make('summary')->required()->rows(2)->maxLength(500)->columnSpanFull(),
                Textarea::make('body')->label('Details')->rows(5)->columnSpanFull(),
            ]);
    }
}
