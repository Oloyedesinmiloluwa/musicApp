<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Album;
use App\Track;

class AlbumTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A feature test for album creation.
     *
     * @return void
     */
    public function testCreateAlbum()
    {
        $response = $this->post('/api/v1/albums', [
            'album' => [
                'name' => 'My album','come' => 'kd'
            ]
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['msg', 'data' ]);
    }

    public function testAddTrack()
    {
        $album = Album::create([
            'name' => 'my album'
        ]);
        $track = Track::create([
            'name' => 'New Track'
        ]);
        $response = $this->call('PUT', "/api/v1/albums/{$album->id}/track/{$track->id}");
        $response->assertStatus(200);
        $response->assertJson(['msg' => "Track added to {$album->name} Album"]);
        $response->assertJsonStructure(['msg', 'data']);
    }
}
