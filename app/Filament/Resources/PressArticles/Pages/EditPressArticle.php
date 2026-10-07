<?php

namespace App\Filament\Resources\PressArticles\Pages;

use App\Filament\Resources\PressArticles\PressArticleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPressArticle extends EditRecord
{
    protected static string $resource = PressArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
