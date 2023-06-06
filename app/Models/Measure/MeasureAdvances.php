<?php

namespace App\Models\Measure;

use App\Abstracts\Model;
use App\Events\Measure\MeasureAdvanceUpdated;
use App\Events\MeasureAdvance\MeasureAdvanceDeleted;
use App\Events\Projects\Activities\TaskDetailUpdated;
use App\Models\Comment;
use App\Models\Indicators\Units\IndicatorUnits;
use App\Models\Projects\Activities\Task;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Plank\Mediable\Mediable;

class MeasureAdvances extends Model
{
    use Mediable;

    const AGGREGATION_TYPE_SUM = 'sum';
    const AGGREGATION_TYPE_AVE = 'ave';
    protected $table = 'msr_measure_advances';
    protected bool $tenantable = false;

    protected $fillable =
        [
            'goal',
            'actual',
            'aggregation_type',
            'period_id',
            'measurable_type',
            'measurable_id',
            'men',
            'women',
            'period',
            'unit_id',
        ];

    protected $casts =
        [
            'period' => 'datetime:Y-m'
        ];

    protected static function boot()
    {
        parent::boot();
        static::updated(function ($model) {
            if (($model->isDirty('men') || $model->isDirty('women')) && !isset($model->getChanges()['actual'])) {
                $model->actual = $model->men + $model->women;
                $model->save();
            }
        });

        static::creating(function ($model) {
            $model->measure_id = $model->measurable->measure_id;
        });

    }

    /**
     * @return MorphTo
     */
    public function measurable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class, 'period_id');
    }

    /**
     * @return BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(IndicatorUnits::class, 'unit_id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->withoutGlobalScope(\App\Scopes\Company::class);
    }

}
