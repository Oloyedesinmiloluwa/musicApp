<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CamelCase;
class Playlist extends Model
{
    use CamelCase;
    protected $fillable = [
        'name', 'userId'
    ];
}
