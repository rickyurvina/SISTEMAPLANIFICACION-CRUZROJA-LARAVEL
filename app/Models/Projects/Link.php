<?php

namespace App\Models\Projects;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Link extends Model
{
    use HasFactory;

    protected $table = 'prj_links';

    protected bool $tenantable = false;
    protected $forceDeleting = true;
}
