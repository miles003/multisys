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
class OrderTest extends TestCase
{
    use WithFaker;
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_for_successfully_order()
    {
        $product = Product::factory()->create();
        $payload = [
            'product_id' => $product->id,
            'quantity' => 1
        ];
        $token = JWTAuth::fromUser(User::factory()->create());
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('post', '/api/order', $payload);
        $response->assertStatus(201);
    }
    /**
     * Unsuccessfull function
     *
     * @return void
     */
    public function test_for_unsuccessfull_order_due_to_unsificient_stock()
    {
        $product = Product::factory()->create();
        $payload = [
            'product_id' => $product->id,
            'quantity' => $product->available_stock + 1
        ];
        $token = JWTAuth::fromUser(User::factory()->create());
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('post', '/api/order', $payload);
        $response->assertStatus(400);
    }
}
