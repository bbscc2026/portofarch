<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'summary', 'body', 'sort_order'])]
class Service extends Model
{
    //
}
