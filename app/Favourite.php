<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CamelCase;
class Favourite extends Model
{
    use CamelCase;

    protected $fillable = [
        'trackId', 'userId'
    ];
}
