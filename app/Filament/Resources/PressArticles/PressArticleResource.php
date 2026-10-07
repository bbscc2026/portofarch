<?php

namespace App\Filament\Resources\PressArticles;

use App\Filament\Resources\PressArticles\Pages\CreatePressArticle;
use App\Filament\Resources\PressArticles\Pages\EditPressArticle;
use App\Filament\Resources\PressArticles\Pages\ListPressArticles;
use App\Filament\Resources\PressArticles\Schemas\PressArticleForm;
use App\Filament\Resources\PressArticles\Tables\PressArticlesTable;
use App\Models\PressArticle;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PressArticleResource extends Resource
{
    protected static ?string $model = PressArticle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return PressArticleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PressArticlesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPressArticles::route('/'),
            'create' => CreatePressArticle::route('/create'),
            'edit' => EditPressArticle::route('/{record}/edit'),
        ];
    }
}
