<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable(['project_id', 'path', 'caption', 'is_wide', 'sort_order'])]
class ProjectImage extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['is_wide' => 'boolean'];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function url(): string
    {
        return Storage::disk('public')->url($this->path);
    }
}
