<?php

namespace App\Http\Controllers\Api\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'year' => $this->year,
            'type' => $this->type,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'balance' => $this->balance->formatByDecimal()
        ];
    }
}
