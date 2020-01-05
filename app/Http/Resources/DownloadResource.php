<?php

namespace App\Http\Resources;

use App\Utilities\Image;
use Illuminate\Http\Resources\Json\JsonResource;

class DownloadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $image = new Image();
        return [
            'id' => $this->id,
            'image_id' => $this->image_id,
            'image_url' => $image($this->fileid),
            'purchased_at' => $this->created_at->format('d/m/Y'),
            'amount' => number_format(($this->value / 2) / 100, 2),
        ];
        //return [];
        // return [
        //     'image_id' => $this->image_id,
        //     'value' => $this->value,

        // ];
        //return parent::toArray($request);
    }
}