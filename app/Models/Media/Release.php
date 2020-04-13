<?php

namespace App\Models\Media;

use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    protected $connection = 'media';

    public function videos()
    {
        return $this->belongsToMany('App\Models\Media\Video');
    }
}