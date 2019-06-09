<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Track;
use App\Playlist;
use App\Rating;
use App\Favourite;
use Illuminate\Support\Facades\Storage;

class TrackController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth')->only('destroy', 'rateAndComment');
    }
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
            'track.name' => 'required',
            'audio' => 'required|file|max:2000|mimetypes:audio/mpeg'
        ]);

        /* if (!in_array($request->file('audio')->getClientOriginalExtension(), ['mp3', 'mp4'])) {
            return response()->json(['audio' => ['Please upload your audio in mp3 or mp4 format']]);
        }; */
        $path = $request->file('audio')->store('Tracks');//Todo: file extension must march the uploaded file extension
        $input = $request->track;
        $input['url'] = $path;
        $track = Track::create($input);
        return response()->json([
            'msg' => 'Track successfully Added',
            'data' => [
                'track' => $track
                ]
            ],
        201);
    }

    public function rateAndComment (Request $request, Track $track)
    {
        $this->validate($request, [
            'rating.text' => 'max:250',
            'rating.rating' => 'required|int'//between 1 and 5
        ]);
        $input = $request->rating;
        $input['trackId'] = $track->id;
        $input['userId'] = auth()->user()['id'];
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

    public function download(Request $request, Track $track)
    {
       return Storage::download($track->url);
    }

    public function destroy(Request $request, Track $track)
    {
        Storage::delete($track->url);
        $track->delete();
        return response()->json(['msg' => 'Track successfully deleted']);
    }

    public function show(Request $request, Track $track)
    {
        return response()->json([
            'data' => [
            'track' => $track
        ]]);
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
