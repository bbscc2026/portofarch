<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Models\Project;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('cover_image')->disk('public')->label(''),
                TextColumn::make('title')->searchable()->weight('medium'),
                TextColumn::make('category')->badge(),
                TextColumn::make('location')->toggleable(),
                TextColumn::make('status'),
                TextColumn::make('images_count')->counts('images')->label('Images'),
                ToggleColumn::make('is_featured')->label('Featured'),
                ToggleColumn::make('is_published')->label('Published'),
            ])
            ->filters([
                SelectFilter::make('category')->options(array_combine(Project::CATEGORIES, Project::CATEGORIES)),
            ])
            ->recordActions([
                Action::make('view')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Project $record) => route('projects.show', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
