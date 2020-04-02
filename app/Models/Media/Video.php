<?php

namespace App\Models\Media;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $connection = 'media';

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    const CREATED_AT = 'uploaded_at';
    const UPDATED_AT = 'updated_at';

    public function setKeywordsAttribute($keywords)
    {
        $result = [];
        foreach ($keywords as $keyword) {
            $result[] = $keyword['value'];
        }
        $this->attributes['keywords'] = implode(', ', $result);
    }

    public function getKeywordsAttribute($keywords)
    {
        $keywords = explode(', ', $keywords);
        $result = [];
        foreach ($keywords as $keyword) {
            $result[] = ['key' => '', 'value' => $keyword];
        }
        return $result;
    }
}