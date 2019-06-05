<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CamelCase;
class Album extends Model
{
    use CamelCase;
    protected $fillable = ['name', 'genreId'];

    public function tracks()
    {
        return $this->hasMany('App\Track', 'albumId', 'id');
    }
}
