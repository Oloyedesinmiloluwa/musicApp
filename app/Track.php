<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CamelCase;

class Track extends Model
{
    // use CamelCase;
    protected $fillable = [
        'name', 'url'
    ];

    public function playlists()
    {
        return $this->belongsToMany('App\Playlist', 'playlist_track', 'trackId', 'playlistId', 'id', 'id')
        ->withTimestamps('createdAt', 'updatedAt');//till the fix for update to permit camelcase
    }

    public function ratings()
    {
        return $this->hasMany('App\Rating', 'trackId', 'id');
    }
}
