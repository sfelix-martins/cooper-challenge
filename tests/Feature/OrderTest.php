<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\HasOrderAsserts;

class OrderTest extends TestCase
{
    use RefreshDatabase, HasOrderAsserts;

    /**
     * @test
     */
    public function it_ll_list_all_orders()
    {
        factory(Order::class, 3)->create();

        $orders = Order::all();

        $this->get('/orders')
            ->assertSuccessful()
            ->assertViewIs('orders.index')
            ->assertViewHas('orders', $orders);
    }

    /**
     * @test
     */
    public function it_ll_show_create_form()
    {
        factory(Product::class, 3)->create();

        $products = Product::all();

        $this->get('/orders/create')
            ->assertSuccessful()
            ->assertViewIs('orders.create')
            ->assertViewHas('products', $products);
    }

    /**
     * @test
     */
    public function it_ll_store_an_order_with_product_with_empty_amount()
    {
        $product = factory(Product::class)->create([
            'amount' => 0,
        ]);

        $order = $this->makeOrderParams($product);

        $this->post('/orders', $order)
            ->assertViewIs('orders.create');

        $this->assertDatabaseMissing('orders', [
            'product_id' => $product->id,
        ]);
    }

    /**
     * @test
     */
    public function it_ll_store_an_order_with_product_with_not_empty_amount()
    {
        $product = factory(Product::class)->create([
            'amount' => 8,
        ]);

        $order = $this->makeOrderParams($product, [
            'amount' => 2,
        ]);

        $this->post('/orders', $order)
            ->assertRedirect('/orders');

        $order['requester_address'] = json_encode($order['requester_address']);

        $this->assertDatabaseHas('orders', $order);

        $this->assertProductSubtractedFromStock($product, 2);
    }

    /**
     * @test
     */
    public function it_ll_show_an_order()
    {
        $order = factory(Order::class)->create();

        $this->get('/orders/'.$order->id)
            ->assertViewIs('orders.show')
            ->assertViewHas('order', $order);
    }

    /**
     * @test
     */
    public function it_ll_show_the_edit_order_form()
    {
        $createdProducts = factory(Product::class, 3)->create([
            'amount' => 1
        ]);

        $products = Product::all()->pluck('name', 'id');

        $order = factory(Order::class)->create([
            'product_id' => $createdProducts->first()->id,
            'amount' => 1,
        ]);

        $this->get('/orders/'.$order->id.'/edit')
            ->assertViewIs('orders.edit')
            ->assertViewHas([
                'order' => $order,
                'products' => $products,
                'statuses' => OrderStatus::ALL,
            ]);
    }

    /**
     * @test
     */
    public function it_ll_update_an_order_with_product_with_empty_amount()
    {
        $olderProduct = factory(Product::class)->create([
            'amount' => 2,
        ]);

        $order = factory(Order::class)->create([
            'amount' => 2,
            'product_id' => $olderProduct->id,
        ]);

        $product = factory(Product::class)->create([
            'amount' => 0,
        ]);

        $orderParams = $this->makeOrderParams($product, ['amount' => 1]);

        $this->put('/orders/'.$order->id, $orderParams)
            ->assertViewIs('orders.edit');

        $this->assertDatabaseMissing('orders', [
            'product_id' => $product->id,
            'id' => $order->id
        ]);

        // Assert older product still related with order
        $this->assertDatabaseHas('orders', [
            'product_id' => $olderProduct->id,
            'id' => $order->id
        ]);

        // Assert older product amount still subtracted
        $this->assertDatabaseHas('products', [
            'id' => $olderProduct->id,
            'amount' => 0,
        ]);
    }

    /**
     * @test
     */
    public function it_ll_update_an_order_with_product_with_not_empty_amount()
    {
        $olderProduct = factory(Product::class)->create([
            'amount' => 3,
        ]);

        $order = factory(Order::class)->create([
            'amount' => 2,
            'product_id' => $olderProduct->id,
        ]);

        $product = factory(Product::class)->create([
            'amount' => 2,
        ]);

        $orderParams = $this->makeOrderParams($product, ['amount' => 1]);

        $this->put('/orders/'.$order->id, $orderParams)
            ->assertRedirect('/orders');

        $orderParams['requester_address'] = json_encode($orderParams['requester_address']);

        // Assert new product related with orders
        $this->assertDatabaseHas('orders', array_merge([
            'id' => $order->id,
        ], $orderParams));

        // Assert product no more related with order.
        $this->assertDatabaseMissing('orders', [
            'order_id' => $order->id,
            'id' => $olderProduct->id,
        ]);

        // Assert devolved the amount to product when remove from order.
        $this->assertDatabaseHas('products', [
            'id' => $olderProduct->id,
            'amount' => 3,
        ]);
    }

    /**
     * @test
     */
    public function it_ll_delete_an_order()
    {
        $order = factory(Order::class)->create();

        $this->delete('/orders/'.$order->id)
            ->assertRedirect('/orders');

        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);
    }

    /**
     * @test
     */
    public function it_ll_try_delete_a_product_related_with_an_order()
    {
        $product = factory(Product::class)->create([
            'amount' => 1,
        ]);
        $order = factory(Order::class)->create([
            'product_id' => $product->id,
            'amount' => 1,
        ]);

        $this->delete('/products/'.$product->id)
            ->assertRedirect('/products');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'product_id' => $product->id,
        ]);

        $this->assertSoftDeleted('products', [
            'id' => $product->id,
        ]);
    }

    private function makeOrderParams(Product $product, array $options = [])
    {
        $data = array_merge(['product_id' => $product->id], $options);

        return factory(Order::class)->make($data)->toArray();
    }
}
