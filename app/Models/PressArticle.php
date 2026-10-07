<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['project_id', 'publication', 'title', 'url', 'published_on', 'sort_order'])]
class PressArticle extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['published_on' => 'date'];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
