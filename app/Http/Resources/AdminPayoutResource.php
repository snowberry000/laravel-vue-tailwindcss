<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminPayoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uid' => $this->uid,
            'user' => $this->user,
            'memo' => $this->memo,
            'created_at' => $this->created_at->format('d/m/Y'),
            'paid_at' => $this->paid_at,
            'amount' => number_format(($this->amount) / 100, 2),
        ];

    }
}