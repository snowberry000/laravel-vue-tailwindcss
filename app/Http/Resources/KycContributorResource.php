<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KycContributorResource extends JsonResource
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
            'created_at' => $this->created_at,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'kyc_verified_at' => $this->kyc_verified_at,
            'sales' => $this->downloads->sum('value') / 2 / 100,
            'available' => $this->unpaidDownloads->sum('value') / 2 / 100,
            'paidout' => $this->payouts->sum('amount') / 100,
            'kycs' => $this->kycs,
        ];
        //return parent::toArray($request);
    }
}