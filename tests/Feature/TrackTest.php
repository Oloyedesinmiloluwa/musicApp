<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Playlist;
use App\Track;
use App\Rating;

class TrackTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A feature test for creation of track.
     *
     * @return void
     */
    public function testCreateTrack()
    {
        $response = $this->post('/api/v1/tracks', [
            'track' => [
                'name' => 'new Track'
            ]
        ]);
        // dump($response->json());
        $response->assertStatus(201);
    }

    public function testAddToPlaylist()
    {
        $playlist = new Playlist();
        $playlist->name = 'my playlist';
        $playlist->save();
        $track = Track::create(['name' => 'Track 1']);
        $response = $this->put("/api/v1/playlists/{$playlist->id}/track/{$track->id}");
        $response->assertJson([
            'msg' => 'Track added to playlist'
        ]);
    }

    public function testAddToPlaylistTheSecondTime()
    {
        $playlist = new Playlist();
        $playlist->name = 'my playlist';
        $playlist->save();
        $track = Track::create(['name' => 'Track 1']);
        $response = $this->put("/api/v1/playlists/{$playlist->id}/track/{$track->id}");
        $response = $this->put("/api/v1/playlists/{$playlist->id}/track/{$track->id}");
        $response->assertJson([
            'msg' => 'You have already added this track'
        ]);
    }

    public function testRateAndComment()
    {
        $track = Track::create(['name' => 'Track 1']);
        $response = $this->put("/api/v1/tracks/{$track->id}/rate", [
            'rating' => [
                'text' => 'Good track, it feels my soul with no bugs',
                'rating' => 5
            ]
        ]);
        dump($response->json());
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'msg',
            'data' => [
                'rating'
            ]
        ]);
    }

    public function testGetRatings()
    {
        $track = Track::create(['name' => 'Track 1']);
        Rating::create(['text' => 'Good', 'rating' => 1, 'trackId' => $track->id, 'userId' => 1]);
        $response = $this->get("/api/v1/tracks/$track->id/ratings");
        $response->assertStatus(200);
        $response->assertJsonStructure([ 'data' => [
            'ratings'
        ] ]);
    }

    public function testViewTrack()
    {
        Track::create(['name' => 'Track 1']);
        $response = $this->get('/api/v1/tracks');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'track'
            ]
        ]);
    }

    public function testFavouriteTrack()
    {
        $track = Track::create(['name' => 'Track 1']);
        $response = $this->put("/api/v1/tracks/{$track->id}/favourite");
        $response->assertStatus(200);
        $response->assertJson(['msg' => "Track {$track->name} is now a favourite" ]);
    }
}
