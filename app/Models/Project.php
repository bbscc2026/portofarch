<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'title', 'slug', 'category', 'location', 'client', 'year', 'status', 'area', 'scope', 'credits',
    'excerpt', 'tagline', 'body', 'cover_image', 'is_featured', 'is_published', 'sort_order', 'meta_description',
])]
class Project extends Model
{
    /** @var list<string> */
    public const CATEGORIES = ['Education', 'Retail', 'Hospitality', 'Commercial', 'Residential', 'Cultural'];

    /** @var list<string> */
    public const STATUSES = ['Realised', 'In progress', 'Concept'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    public function pressArticles(): HasMany
    {
        return $this->hasMany(PressArticle::class)->orderBy('sort_order');
    }

    /**
     * @param  Builder<Project>  $query
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true)->orderBy('sort_order');
    }

    public function coverUrl(): ?string
    {
        return $this->cover_image ? Storage::disk('public')->url($this->cover_image) : null;
    }

    /**
     * Body paragraphs, split on blank lines.
     *
     * @return list<string>
     */
    public function paragraphs(): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\R{2,}/', (string) $this->body))));
    }
}
