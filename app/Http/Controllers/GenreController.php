<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Genre;

class GenreController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'genre.name' => 'required|max:30',
            'genre.description' => 'max:250'
        ]);
       $genre = Genre::create($request->genre);
       return response()->json([ 'msg' => 'Genre successfully created', 'data' => $genre ], 201);
    }
}
