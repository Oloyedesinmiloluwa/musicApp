<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Playlist;
use App\Track;
use App\Rating;
use App\User;

class TrackTest extends TestCase
{
    use RefreshDatabase;

    public function createTrack()
    {
        $user = User::create([
            'firstName' => 'First',
            'lastName' => 'we',
            'email' => 'we@yahoo.com',
            'password' => 'passwordA1'
        ]);
        $track = Track::create(['name' => 'Track 1', 'url' => 'here.mp3', 'userId' => $user->id ]);
        return $track;
    }
    /**
     * A feature test for creation of track.
     *
     * @return void
     */
    public function testCreateTrack()
    {
        $response = $this->post('/api/v1/tracks', [
            'audio' => UploadedFile::fake()->create('test.mp3', 100),
            'track' => [
                'name' => 'new Track'
            ]
            ]);

            $response->assertStatus(201);
            $response->assertJsonStructure([
                'msg',
                'data' => [
                    'track'
                ]
            ]);
            return $response->json();
    }

    public function testAddToPlaylist()
    {
        $playlist = new Playlist();
        $playlist->name = 'my playlist';
        $playlist->save();
        $track = $this->createTrack();
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
        $track = $this->createTrack();
        $response = $this->put("/api/v1/playlists/{$playlist->id}/track/{$track->id}");
        $response = $this->put("/api/v1/playlists/{$playlist->id}/track/{$track->id}");
        $response->assertJson([
            'msg' => 'You have already added this track'
        ]);
    }

    public function testRateAndComment()
    {
        $track = $this->createTrack();
        $user = User::first();
        $token = auth()->login($user);
        $response = $this->put("/api/v1/tracks/{$track->id}/rate?token=$token", [
            'rating' => [
                'text' => 'Good track, it feels my soul with no bugs',
                'rating' => 5
            ]
        ]);

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
        $track = $this->createTrack();
        Rating::create(['text' => 'Good', 'rating' => 1, 'trackId' => $track->id, 'userId' => 1]);
        $response = $this->get("/api/v1/tracks/$track->id/ratings");
        $response->assertStatus(200);
        $response->assertJsonStructure([ 'data' => [
            'ratings'
        ] ]);
    }

    public function testViewTrack()
    {
        $track = $this->createTrack();
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
        $track = $this->createTrack();
        $response = $this->put("/api/v1/tracks/{$track->id}/favourite");
        $response->assertStatus(200);
        $response->assertJson(['msg' => "Track {$track->name} is now a favourite" ]);
    }

    public function testDownload()
    {
        $trackId = $this->testCreateTrack()['data']['track']['id'];
        $response = $this->get("/api/v1/tracks/{$trackId}/download");
        $response->assertStatus(200);
    }

    public function testGetTrack()
    {
        $response = $this->get('/api/v1/tracks/');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['track']
        ]);
    }

    public function testSingleTrack()
    {
        $track = $this->createTrack();
        $response = $this->get("/api/v1/tracks/{$track->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['track']
        ]);
    }

    public function testDestroy()
    {
        $track = $this->createTrack();
        $user = User::first();
        $token = auth()->login($user);
        $response = $this->delete("/api/v1/tracks/{$track->id}?token=$token");
        $response->assertStatus(200);
        $response->assertJsonStructure(['msg']);
    }
}
