<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GenreTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A feature test for Genre creation.
     *
     * @return void
     */
    public function testCreateGenre()
    {
        $response = $this->post('/api/v1/genres', [
            'genre' => [
                'name' => 'New Afro',
                'description' => 'The newest Afro beat in town'
            ]
        ]);
        $response->assertStatus(201);
        $response->assertJsonStructure(['msg', 'data']);
    }

    public function testGetSingleGenre()
    {
        $response = $this->get('/api/v1/genres');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['genre']
        ]);
    }

    public function testGetSingleGenreWithQuery()
    {
        $response = $this->get('/api/v1/genres?name=afro');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['genre']
        ]);
    }
}
