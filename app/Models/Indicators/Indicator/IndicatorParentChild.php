<?php

namespace App\Models\Indicators\Indicator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicatorParentChild extends Model
{
    use HasFactory;
    protected $table = 'indicator_parent_child';

    /**
     * @var bool
     */
    public $timestamps = true;
    protected $fillable = [
        'parent_indicator',
        'child_indicator',
    ];


    /**
     * Obtener la unidad de medida.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'child_indicator')->orderBy('id', 'ASC');
    }

}
