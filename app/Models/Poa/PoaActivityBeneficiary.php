<?php

namespace App\Models\Poa;

use App\Models\Common\CatalogDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PoaActivityBeneficiary extends Model
{
    protected bool $tenantable = false;

    protected $fillable=['beneficiary_id','poa_activity_id'];

    public function beneficiaries(): BelongsTo
    {
        return $this->belongsTo(CatalogDetail::class, 'beneficiary_id');
    }
    public function poaActivity(){
        return $this->belongsTo(PoaActivity::class,'poa_activity_id');
    }

}
