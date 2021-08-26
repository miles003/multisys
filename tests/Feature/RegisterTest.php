<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Product;

class RegisterTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_for_register_email_already()
    {
        $user = User::factory()->create();
        $response = $this->post('/api/register', [
            'name' => 'test name',
            'email' => $user->email,
            'password' => 'secret',
            'password_confirmation' => 'secret' 
        ]);

        $response->assertStatus(422);
    }
    public function test_for_successfull_register()
    {
        $response = $this->post('/api/register', [
            'name' => 'test name',
            'email' => 'test@email.com',
            'password' => 'secret',
            'password_confirmation' => 'secret' 
        ]);

        $response->assertStatus(201);
    }
}
