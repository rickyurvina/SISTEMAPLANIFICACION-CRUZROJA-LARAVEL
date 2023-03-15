<?php

namespace App\Http\Controllers\Api\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionDetailResource extends JsonResource
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
            'number' => $this->number,
            'debit' => $this->debit->formatByDecimal(),
            'credit' => $this->credit->formatByDecimal(),
            'description' => $this->description,
            'account' => AccountResource::make($this->account),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
