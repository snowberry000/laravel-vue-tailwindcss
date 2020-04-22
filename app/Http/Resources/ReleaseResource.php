<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReleaseResource extends JsonResource
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
            'key' => $this->id,
            'value' => $this->name,
            'file_uuid' => $this->file_uuid,
            'name' => $this->name,
            'filename' => $this->filename,
            'extension' => $this->extension,
            'created_at' => $this->created_at,
        ];
        return parent::toArray($request);
    }
}