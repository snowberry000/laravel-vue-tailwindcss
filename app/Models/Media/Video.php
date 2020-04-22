<?php

namespace App\Models\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    protected $connection = 'media';

    protected $casts = [
        'uploaded_at' => 'datetime',
        'updated_at' => 'datetime',
        'published_at' => 'datetime',
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
            if (!empty($keyword)) {
                $result[] = ['key' => '', 'value' => $keyword];
            }
        }
        return empty($result) ? null : $result;
    }

    public function getRawkeywordsAttribute()
    {
        $result = explode(', ', $this->attributes['keywords']);
        if (empty($result[0])) {
            return [];
        }

        return $result;
    }

    public function releases()
    {
        return $this->belongsToMany('App\Models\Media\Release');
    }

    public function attachReleases(array $releases)
    {
        $keys = [];
        foreach ($releases as $release) {
            $keys[] = $release['key'];
        }
        $this->releases()->sync($keys);
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'uid', 'uid');
    }
}