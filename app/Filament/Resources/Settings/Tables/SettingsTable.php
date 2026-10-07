<?php

namespace App\Filament\Resources\Settings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->columns([
                TextColumn::make('label')->weight('medium'),
                TextColumn::make('value')->limit(80)->placeholder('—'),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
