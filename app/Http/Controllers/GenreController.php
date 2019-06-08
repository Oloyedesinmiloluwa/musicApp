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

    public function index(Request $request)
    {
        $genres = null;
        $query = $request->query();
        if($query && isset($query['name'])) {
            $genres = Genre::where('name', 'like', '%'.$request->query()['name'].'%')->get();
        }
        if (!$genres) {
            $genres = Genre::all();
        }
        return response()->json(['data' => [
            'genre' => $genres
        ]], 200);
    }
}
