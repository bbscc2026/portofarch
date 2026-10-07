<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'email', 'phone', 'project_type', 'message', 'read_at'])]
class ContactMessage extends Model
{
    /** @var list<string> */
    public const PROJECT_TYPES = ['Interior design', 'Architecture', 'Commercial / retail', 'Hospitality', 'Residential', 'Consultation'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['read_at' => 'datetime'];
    }
}
