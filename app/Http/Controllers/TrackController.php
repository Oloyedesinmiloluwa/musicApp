<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Track;
use App\Playlist;
use App\Rating;
use App\Favourite;

class TrackController extends Controller
{
    public function addToPlaylist(Request $request, Playlist $playlist, Track $track)
    {
        $exitingPlaylist = $track->playlists()->where('playlistId', $playlist->id)->get();
        if (!$exitingPlaylist->isEmpty()) {
            return response()->json([ 'msg' => 'You have already added this track' ]);
        }
        $track->playlists()->attach($track->id, ['playlistId' => $playlist->id ]);
        return response()->json(['msg' => 'Track added to playlist' ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'track.name' => 'required'
        ]);
        $track = Track::create($request->track);
        return response()->json(['msg' => 'Track successfully Added', 'data' => $track ], 201);
    }

    public function rateAndComment (Request $request, Track $track)
    {
        $this->validate($request, [
            'rating.text' => 'max:250',
            'rating.rating' => 'required|int'//between 1 and 5
        ]);
        $input = $request->rating;
        $input['trackId'] = $track->id;
        $input['userId'] = 1; //Todo: update with authenticated user
        $rating = Rating::create($input);
        return response()->json([
            'msg' => 'Rating submitted successfully',
            'data' => [
                'rating' => $rating
            ]
            ], 201);
    }

    public function getRatings(Request $request, Track $track)
    {
        $ratings = $track->ratings()->get();
        return response()->json([
            'data' => [
                'ratings' => $ratings
            ]
        ], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tracks = Track::all();
        return response()->json([
            'data' => [
                'track' => $tracks
            ]
        ], 200);
    }

    public function favouriteTrack(Request $request, Track $track)
    {
        Favourite::firstOrCreate([
            'userId' => 1,
            'trackId' => $track->id
        ]);
        return response()->json(['msg' => "Track {$track->name} is now a favourite" ]);
    }
}
