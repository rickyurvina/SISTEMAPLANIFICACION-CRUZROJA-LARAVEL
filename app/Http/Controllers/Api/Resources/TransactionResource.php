<?php

namespace App\Http\Controllers\Api\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'number' => $this->number,
            'description' => $this->description,
            'status' => $this->status,
            'company_id' => $this->company_id,
            'details' => TransactionDetailResource::collection($this->transactions)
        ];
    }
}
