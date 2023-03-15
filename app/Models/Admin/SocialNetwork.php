<?php

namespace App\Models\Admin;

use App\Abstracts\Model;
use App\Models\Common\CatalogDetail;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialNetwork extends Model
{
    use SoftDeletes;

    protected $table = 'social_networks';

    protected $casts=['type'=>'array'];

    protected $fillable = ['url', 'company_id', 'type', 'enabled'];

    public function catalog(){
        return $this->belongsTo(CatalogDetail::class,'type' );
    }

}
