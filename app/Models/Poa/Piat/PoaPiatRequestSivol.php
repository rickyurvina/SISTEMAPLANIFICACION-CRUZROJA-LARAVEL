<?php

namespace App\Models\Poa\Piat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoaPiatRequestSivol extends Model
{
    const STATUS_OPENED = 'Abierta';
    const STATUS_ACCEPTED = 'Aceptada';
    const STATUS_REFUSED = 'Rechazada';
    protected $fillable=[
        'poa_activity_piat_id',
        'description',
        'response',
        'status',
        'number_request',
        'number_activated',
    ];

    public function poaActivityPiat()
    {
        return $this->belongsTo(PoaActivityPiat::class, 'poa_activity_piat_id');
    }
}
