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
                'password' => 'user1A',
            ]
        ]);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'msg',
            'data' => ['firstName', 'lastName', 'email', 'id']
        ]);
    }

    public function testUserRegisterInvalidPassword()
    {
        $response = $this->post('/api/v1/users', [
            'user' => [
                'firstName' => 'me',
                'lastName' => 'we',
                'email' => 'testtest@musicapp.com',
                'password' => 'user1',
            ]
        ]);
        $response->assertStatus(400);
        $response->assertJson([
            'msg' => 'Your password must contain lowercase, uppercase letters and number character and must be 4 to 8 characters long'
        ]);
    }

    public function testUserRegisterInvalidEmail()
    {
        $response = $this->post('/api/v1/users', [
            'user' => [
                'firstName' => 'me',
                'lastName' => 'we',
                'email' => 'testtemusicapp.com',
                'password' => 'user1A',
            ]
        ]);
        $response->assertStatus(400);
        $response->assertJson([
            'msg' => 'Your provide a valid email'
        ]);
    }

    public function testFavourite()
    {
        $token = auth()->login($this->createUser());
        $response = $this->get("/api/v1/user/favourites?token=$token");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'favourite'
            ]
        ]);
    }

    public function testUpdateProfile()
    {
        $user = $this->createUser();
        $token = auth()->login($user);
        $response = $this->put("/api/v1/users/profile?token=$token", [
            'user' => [
                'bio' => 'I am the best artiste trust me',
                'photo' => 'link to my photo',
                'firstName' => 'My new firstname'
            ]
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'msg',
            'data' => ['user']
        ]);
    }
}
