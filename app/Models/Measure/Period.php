<?php

namespace App\Models\Measure;

use App\Abstracts\Model;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use function trans;

class Period extends Model
{
    use HasFactory;

    protected bool $tenantable = false;

    protected $table = 'msr_periods';

    protected $dates = [];

    protected $appends = ['name'];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d'
    ];

    /**
     * @return array|Application|Translator|int|string|null
     */
    public function getNameAttribute()
    {
        switch ($this->calendar->frequency) {
            case Calendar::FREQUENCY_MONTHLY:
                return Str::ucfirst($this->start_date->isoFormat('MMM'));
            case Calendar::FREQUENCY_QUARTERLY:
                return trans('general.quarter.' . $this->start_date->quarter);
            case Calendar::FREQUENCY_SEMESTER:
                return $this->start_date->month <= 6 ? trans('general.semester.1') : trans('general.semester.2');
            case Calendar::FREQUENCY_YEARLY:
                return $this->start_date->year;
        }
        return '';
    }

    /**
     * @return int
     */
    public function getDaysAttribute()
    {
        return $this->end_date->diffInDays($this->start_date);
    }

    /**
     * @return BelongsTo
     */
    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class, 'calendar_id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(PeriodGroup::class, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function parents(): HasMany
    {
        return $this->hasMany(PeriodGroup::class, 'period_id');
    }

    /**
     * @return HasMany
     */
    public function scores(): HasMany
    {
        return $this->hasMany(Score::class, 'period_id');
    }

    /**
     * @return HasMany
     */
    public function measureAdvances(): HasMany
    {
        return $this->hasMany(MeasureAdvances::class, 'period_id');
    }
}
