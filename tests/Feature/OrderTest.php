<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    /** 
     * @test
     */
    public function successfull_order()
    {
        $user = $this->createUser();
        $product = $this->createproduct();
        $response = $this->actingAs($user)->postJson('api/order', [
            'product_id' => $product['id'],
            'quantity' => 1,
        ]);
        $response->assertStatus(201);
    }
    /** 
     * @test
     */
    public function unsuccessful_due_to_no_available_stock()
    {
        $user = $this->createUser();
        $product = $this->createproduct();
        $response = $this->actingAs($user)->postJson('api/order', [
            'product_id' => $product['id'],
            'quantity' => 999999,
        ]);
        $response->assertStatus(400);
    }
    /** 
     * @test
     */
    public function product_does_not_exists()
    {
        $user = $this->createUser();
        $product = $this->createproduct();
        $response = $this->actingAs($user)->postJson('api/order', [
            'product_id' => 999,
            'quantity' => 999999,
        ]);
        $response->assertStatus(404);
    }
}
