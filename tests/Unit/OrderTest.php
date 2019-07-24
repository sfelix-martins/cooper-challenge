<?php

namespace Tests\Unit;

use App\Exceptions\OrderException;
use App\Models\Order;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\HasOrderAsserts;

class OrderTest extends TestCase
{
    use RefreshDatabase, WithFaker, HasOrderAsserts;

    /**
     * @test
     */
    public function it_ll_throw_an_exception_when_try_create_an_order_with_product_not_available_in_stock()
    {
        $this->expectException(OrderException::class);

        $product = factory(Product::class)->create([
            'amount' => 0,
        ]);

        $order = new Order([
            'amount' => 1,
            'product_id' => $product->id,
        ]);
        $order->save();
    }

    /**
     * @test
     */
    public function it_ll_create_an_order_when_product_is_available()
    {
        $product = factory(Product::class)->create([
            'amount' => 2,
            'value' => 10,
        ]);

        $orderData = [
            'product_id' => $product->id,
            'amount' => 2,
            'requester_name' => $this->faker->name,
            'requester_address' => json_encode(['zipcode' => $this->faker->postcode,
                'uf' => $this->faker->stateAbbr,
                'city' => $this->faker->city,
                'address' => $this->faker->address,
                'number' => $this->faker->buildingNumber,
            ]),
            'forwarding_agent_name' => $this->faker->name,
        ];

        $order = new Order($orderData);
        $order->save();

        $this->assertDatabaseHas('orders', $orderData);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'value' => 20,
        ]);

        $this->assertProductSubtractedFromStock($product, 2);

        $this->assertProductWithUnavailableStatus($product);
    }
}
