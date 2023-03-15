<?php

namespace App\Models\Admin;

use App\Abstracts\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = ['country', 'province', 'city', 'street_one', 'street_two', 'street_three', 'number', 'postal_code', 'latitude', 'longitude', 'enabled', 'company_id'];
}