<?php

namespace App\Models\Process;


use App\Abstracts\Model;
use App\Models\Auth\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Plank\Mediable\Mediable;

class ChangesActivities extends Model
{
    use Mediable;

    protected bool $tenantable = false;

    protected $table = 'process_plan_changes_activities';

    protected $fillable = [
        'code',
        'name',
        'user_id',
        'description',
        'start_date',
        'end_date',
        'process_plan_changes_id',
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    /**
     * Sortable columns.
     *
     * @var array
     */
    public array $sortable =
        [
            'code',
            'name',
            'user_id',
            'description',
            'start_date',
            'end_date',
            'process_plan_changes_id',
        ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->code = mb_strtoupper($model->code);
            $model->name = mb_strtoupper($model->name);
            $model->description = mb_strtoupper($model->description);
        });
        static::updating(function ($model) {
            $model->code = mb_strtoupper($model->code);
            $model->name = mb_strtoupper($model->name);
            $model->description = mb_strtoupper($model->description);
        });
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->withoutGlobalScope(\App\Scopes\Company::class);
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function planChange()
    {
        return $this->belongsTo(ProcessPlanChanges::class, 'process_plan_changes_id');
    }
}
