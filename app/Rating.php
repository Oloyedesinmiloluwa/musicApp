<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CamelCase;
class Rating extends Model
{
    use CamelCase;
    protected $fillable = ['trackId', 'text', 'rating', 'userId'];
}
