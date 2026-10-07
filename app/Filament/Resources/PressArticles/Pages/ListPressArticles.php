<?php

namespace App\Filament\Resources\PressArticles\Pages;

use App\Filament\Resources\PressArticles\PressArticleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPressArticles extends ListRecords
{
    protected static string $resource = PressArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
