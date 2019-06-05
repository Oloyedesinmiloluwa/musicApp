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
        // dump($response->json());
        $response->assertStatus(201);
        $response->assertJsonStructure(['msg', 'data']);
    }
}
