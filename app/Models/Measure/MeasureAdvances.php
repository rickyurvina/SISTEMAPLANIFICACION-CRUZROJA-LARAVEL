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

    protected static function booted()
    {
        static::updated(function ($model) {
            if ((isset($model->getChanges()['actual']))) {
                MeasureAdvanceUpdated::dispatch($model);
//                if ($model->measurable_type==Task::class){
//                TaskDetailUpdated::dispatch($model);
//                    //TODO CALCULAR AVANCE DE REUSLTADOS, OBJETIVOS Y PROYECTO EN CASCADA.
//                }
            }
        });
        static::deleting(function ($model) {
            if ($model->actual > 0) {
                MeasureAdvanceDeleted::dispatch($model);
            }
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
        return $this->morphMany(Comment::class, 'commentable')->withoutGlobalScope(\App\Scopes\Company::class);
    }

}
