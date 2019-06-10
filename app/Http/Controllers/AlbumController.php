<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Album;
use App\Track;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     * @codeCoverageIgnore
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'album.name' => 'required|max:50',
        ]);
        $album = Album::create($request->album);
        return response()->json(['msg' => 'Album created successfully', 'data' => $album ], 201);
    }

    public function addTrack (Request $request, Album $album, Track $track)
    {
        $track->albumId = $album->id;
        $track->save();
        return response()->json(['msg' => "Track added to {$album->name} Album", 'data' => $track ], 200);//Todo: wrap track in track property
    }

    /**
     * Display the specified resource.
     * @codeCoverageIgnore
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @codeCoverageIgnore
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @codeCoverageIgnore
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
