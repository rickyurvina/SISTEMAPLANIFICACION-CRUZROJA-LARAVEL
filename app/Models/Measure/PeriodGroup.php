<?php

namespace App\Models\Measure;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodGroup extends Model
{
    use HasFactory;

    protected $table = 'msr_period_children';

    protected $dates = [];
}
