<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaylistTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A feature test for creation of playlist.
     *
     * @return void
     */
    public function testCreatePlaylist()
    {
        $response = $this->post('/api/v1/playlists', [
            'playlist' => [
                'name' => 'nice playlist'
            ]
        ]);
            // dump($response->json());
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'msg',
            'data' => [ 'id', 'name']
        ]);
    }
}
