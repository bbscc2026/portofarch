<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\Project;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Project')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state, string $operation) => $operation === 'create' ? $set('slug', Str::slug((string) $state)) : null),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Used in the page address: /projects/your-slug'),
                        Select::make('category')
                            ->options(array_combine(Project::CATEGORIES, Project::CATEGORIES))
                            ->required(),
                        Select::make('status')
                            ->options(array_combine(Project::STATUSES, Project::STATUSES))
                            ->default('Realised')
                            ->required(),
                        TextInput::make('location')->placeholder('Hayy Jameel, Jeddah'),
                        TextInput::make('client'),
                        TextInput::make('year')->placeholder('2024'),
                        TextInput::make('area')->placeholder('850 m²'),
                        TextInput::make('scope')->placeholder('Interior architecture'),
                        TextInput::make('credits')
                            ->helperText('Separate credits with " · "')
                            ->columnSpanFull(),
                        Textarea::make('excerpt')
                            ->helperText('One or two sentences — shown on cards and as the large intro on the project page.')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        TextInput::make('tagline')
                            ->label('Showcase line')
                            ->prefix('We saw the opportunity to…')
                            ->placeholder('turn a language school into a voyage across the Red Sea')
                            ->helperText('Shown on the home page project showcase.')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('body')
                            ->helperText('Project story. Leave an empty line between paragraphs.')
                            ->rows(14)
                            ->columnSpanFull(),
                    ]),
                Section::make('Publishing')
                    ->columnSpan(1)
                    ->schema([
                        FileUpload::make('cover_image')
                            ->image()
                            ->disk('public')
                            ->directory('projects')
                            ->imageEditor()
                            ->maxSize(8192)
                            ->required(),
                        Toggle::make('is_published')->label('Published')->default(true),
                        Toggle::make('is_featured')->label('Featured on home page'),
                        TextInput::make('sort_order')->numeric()->default(0)->helperText('Lower numbers appear first.'),
                        Textarea::make('meta_description')
                            ->label('SEO description')
                            ->rows(3)
                            ->maxLength(300),
                    ]),
            ]);
    }
}
