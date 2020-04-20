<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContributorResource extends JsonResource
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
            'username' => $this->username,
            'email' => $this->email,
            'name' => $this->name,
            'video' => $this->video,
            'kyc_verified_at' => $this->kyc_verified_at,
            'created_at' => $this->created_at->format('d/m/Y'),
        ];
    }
}