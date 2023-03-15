<?php

namespace App\Traits;

use App\Models\Measure\Measure;
use App\Scopes\Company;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasMeasure
{
    public function measures(): MorphMany
    {
        return $this->morphMany(Measure::class, 'indicatorable')->withoutGlobalScope(Company::class);
    }
}
