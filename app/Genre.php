<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CamelCase;
class Genre extends Model
{
    use CamelCase;
    protected $fillable = [
        'name', 'description'
    ];
}
