<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A feature test for user registration.
     *
     * @return void
     */
    public function testUserRegister()
    {
        $response = $this->post('/api/v1/users', [
            'user' => [
                'firstName' => 'me',
                'lastName' => 'we',
                'email' => 'testtest@musicapp.com',
                'password' => 'user',
            ]
        ]);
        // dump($response->json());
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'msg',
            'data' => ['firstName', 'lastName', 'email', 'id' ]
        ]);
    }

    public function testUpdateProfile()
    {
        $user = User::create([
            'firstName' => 'First',
            'lastName' => 'we',
            'email' => 'we@yahoo.com',
            'password' => 'fsljjjlj'
        ]);
        $response = $this->put("/api/v1/users/{$user->id}/profile", [
            'user' => [
                'bio' => 'I am the best artiste trust me',
                'photo' => 'link to my photo',
                'firstName' => 'My new firstname'
            ]
        ]);
        $response->assertJsonStructure([
            'msg',
            'data' => ['user']
        ]);
    }
}
