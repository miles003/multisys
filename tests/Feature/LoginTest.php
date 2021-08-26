<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_for_user_can_logged_in()
    {
        $email = 'test@email.com';
        $password = 'secret';
        User::factory()->create(
            [
                'email' => $email,
                'password' => Hash::make($password)
            ]
        );

        $response = $this->post('/api/login', [
            'email' => $email,
            'password' => $password
        ]);
        $response->assertStatus(200);
    }
    public function test_for_too_many_attempts_login()
    {
        $email = 'test1@email.com';
        $password = 'secret1';
        User::factory()->create(
            [
                'email' => $email,
                'password' => Hash::make($password)
            ]
        );

        //Make a 5x bad request
        for ($i = 0; $i < 5; ++$i) {
            $response = $this->post('api/login', [
                'email' => $email,
                'password' => 'secret123'
            ]);

            $response->assertStatus(401);
        }

        //Test for throttle
        $response = $this->post('api/login', [
                    'email' => $email,
                    'password' => 'secret123'
        ]);

        $response->assertStatus(429);
    }
}
