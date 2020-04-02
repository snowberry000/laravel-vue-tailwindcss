<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $cdn_url = config('services.video.cdn_path');

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'uid' => $this->uid,
            'preview' => $cdn_url . $this->file_uuid . '.mp4',
            'thumbnail' => $cdn_url . $this->file_uuid . '.0000000.jpg',
            'codec' => $this->codec,
            'original_name' => $this->original_name,
            'width' => $this->width,
            'height' => $this->height,
            'framerate' => $this->framerate,
            'duration' => gmdate("H:i:s", $this->duration),
            'size' => number_format($this->size / 1048576, 2),
            '4k' => $this->{'4k'},
            'uploaded_at' => $this->uploaded_at->format('d/m/Y'),
            'status' => $this->status,
        ];
    }
}