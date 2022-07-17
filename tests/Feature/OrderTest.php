<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderFilling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{

    public function test_post_exists()
    {
        $response = $this->post('/api/order', ['bun' => 'Sesame', 'filling' => 'Meef']);
        $response->assertStatus(200);
    }

    public function test_post_rejects_bad_data_values()
    {
        $response = $this->post('/api/order', ['bun' => 'brioch', 'filling' => 'turkey']);
        $response->assertStatus(400);
    }

    public function test_post_rejects_bad_data_keys()
    {
        $response = $this->post('/api/order', ['bun' => 'Sesame', 'filling' => 'Meef', 'Size' => 'Super']);
        $response->assertStatus(400);
    }

    public function test_post_rejects_missing_data()
    {
        $response = $this->post('/api/order', []);
        $response->assertStatus(400);
    }

    public function test_post_creates_order()
    {
        $orderCount = Order::count();
        $this->post('/api/order', ['bun' => 'Sesame', 'filling' => 'Meef']);
        $this->assertEquals(Order::count(), $orderCount + 1);
    }

    public function test_post_adds_single_filling()
    {
        $orderCount = OrderFilling::count();
        $this->post('/api/order', ['bun' => 'Sesame', 'filling' => 'Meef']);
        $this->assertEquals(OrderFilling::count(), $orderCount + 1);
    }

    public function test_post_creates_adds_multiple_fillings()
    {
        $orderCount = OrderFilling::count();
        $this->post('/api/order', ['bun' => 'Sesame', 'filling' => 'Meef,Tomato']);
        $this->assertEquals(OrderFilling::count(), $orderCount + 2);
    }


    public function test_patch_exists()
    {
        $id = Order::first()['pkId'];
        $response = $this->patch("/api/order/{$id}", ['bun' => 'Sesame', 'filling' => 'Meef']);
        $response->assertStatus(200);
    }

    public function test_patch_rejects_bad_data_values()
    {
        $id = Order::first()['pkId'];
        $response = $this->patch("/api/order/{$id}", ['bun' => 'brioch', 'filling' => 'turkey']);
        $response->assertStatus(400);
    }

    public function test_patch_rejects_bad_data_keys()
    {
        $id = Order::first()['pkId'];
        $response = $this->patch("/api/order/{$id}", ['bun' => 'Sesame', 'filling' => 'Meef', 'Size' => 'Super']);
        $response->assertStatus(400);
    }

    public function test_delete_exists()
    {
        $id = Order::first()['pkId'];
        $response = $this->delete("/api/order/{$id}");
        $response->assertStatus(200);
    }


    public function test_delete_removes_order_record()
    {
        $id = Order::first()['pkId'];
        $count = Order::count();
        $this->delete("/api/order/{$id}");
        $this->assertLessThan($count, Order::count());
    }


    public function test_delete_removes_order_filling_record()
    {
        $id = Order::first()['pkId'];
        $count = OrderFilling::count();
        $this->delete("/api/order/{$id}");
        $this->assertLessThan($count, OrderFilling::count());
    }
}
