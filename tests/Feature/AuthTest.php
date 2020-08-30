<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_register()
    {
        $response = $this->json('POST', 'api/auth/register/', [
            'name' => 'User Test',
            'email' => 'email@email.com',
            'password' => 'password'
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['message']);
        $response->assertJson(['message'=>'User register successfully']);

        $this->assertDatabaseHas('users', [
            'name' => 'User Test',
            'email' => 'email@email.com',
        ]);
    }

    public function test_user_login()
    {
        $this->withoutExceptionHandling();
        $this->artisan('passport:install');

        $user = factory(User::class)->create();
        $response = $this->json('POST', 'api/auth/login/', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['access_token', 'user_id']);
    }


}
