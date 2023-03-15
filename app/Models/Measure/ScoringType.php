<?php

namespace App\Models\Measure;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScoringType extends Model
{
    use HasFactory;

    const TYPE_YES_NO = 'yes-no';
    const TYPE_GOAL_ONLY = 'goal-only';
    const TYPE_GOAL_RED_FLAG = 'goal-red-flag';
    const TYPE_THREE_COLORS = 'three-colors';
    const TYPE_TWO_COLORS = 'two-colors';
    protected bool $tenantable = false;

    protected $table = 'msr_scoring_types';
    protected $dates = [];
    protected $casts = [
        'config' => 'array',
    ];


}
