<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function createUser()
    {
        $user = User::create([
            'firstName' => 'First',
            'lastName' => 'we',
            'email' => 'we@yahoo.com',
            'password' => 'passwordA1'
        ]);
        return $user;
    }
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
        // $response->assertStatus(201);
        $response->assertJson([]);
        $response->assertJsonStructure([
            'msg',
            'data' => ['firstName', 'lastName', 'email', 'id' ]
        ]);
    }

    public function testUpdateProfile()
    {
        $user = $this->createUser();
        /* $user = User::create([
            'firstName' => 'First',
            'lastName' => 'we',
            'email' => 'we@yahoo.com',
            'password' => 'fsljjjlj'
        ]); */
        $response = $this->put("/api/v1/users/profile", [
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

    public function testLogin()
    {
        $this->createUser();
        $response = $this->post('/api/v1/auth/login', [
            'user' => [
                'email' => 'we@yahoo.com',
                'password' => 'passwordA1'
            ]
        ]);
        $response->assertJson(['msg' => 'Login successful']);
    }
}
