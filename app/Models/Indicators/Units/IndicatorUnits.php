<?php

namespace App\Models\Indicators\Units;

use App\Abstracts\Model;
use App\Models\Indicators\Indicator\Indicator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndicatorUnits extends Model
{
    use HasFactory;


    const PEOPLE_REACHED = "PA";
    const TRAINED_PEOPLE = 'PCap';
    const EVALUATION = 'Eva';
    const DOCUMENTS = 'Doc';

    protected bool $tenantable = false;

    protected $casts = ['information_sources' => 'array'];

    protected $fillable = ['name', 'abbreviation', 'is_for_people'];

    public $sortable = ['name', 'abbreviation'];

    /**
     * Obtener el Indicador al que pertenece
     *
     * @return BelongsTo
     */

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = strtoupper($model->name);
        });
        static::updating(function ($model) {
            $model->name = strtoupper($model->name);
        });
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indicators_id');
    }

    public function getUnits()
    {
        return
            [
                0 => $this->where('abbreviation', IndicatorUnits::PEOPLE_REACHED)->first(),
                1 => $this->where('abbreviation', IndicatorUnits::TRAINED_PEOPLE)->first(),
                2 => $this->where('abbreviation', IndicatorUnits::EVALUATION)->first(),
                3 => $this->where('abbreviation', IndicatorUnits::DOCUMENTS)->first()
            ];
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        $abrreviation = $this->abbreviation;
        switch ($abrreviation) {
            case self::PEOPLE_REACHED:
                return 'fal fa-users fa-lg mr-2';
            case self::TRAINED_PEOPLE:
                return 'fal fa-users-class fa-lg mr-2';
            case self::DOCUMENTS:
                return 'fal fa-file-chart-line fa-lg mr-2';
            case self::EVALUATION:
                return 'fal fa-badge-percent fa-lg mr-2';
            default:
                return 'fal fa-circle fa-lg mr-2';
        }
    }
}
