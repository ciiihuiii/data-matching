<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchingSession extends Model
{
    protected $fillable = [
        'name',
        'source_a_file',
        'source_a_sheet',
        'source_b_file',
        'source_b_sheet',
        'comparison_type',
        'status',
    ];
}
