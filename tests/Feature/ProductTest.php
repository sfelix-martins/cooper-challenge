<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductStatus;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function it_ll_list_all_products()
    {
        factory(Product::class, 3)->create();

        $products = Product::all();

        $this->get('/products')
            ->assertSuccessful()
            ->assertViewIs('products.index')
            ->assertViewHas('products', $products);
    }

    /**
     * @test
     */
    public function it_ll_show_create_form()
    {
        $this->get('/products/create')
            ->assertSuccessful()
            ->assertViewIs('products.create');
    }

    /**
     * @test
     */
    public function it_ll_store_a_product_with_empty_amount()
    {
        $product = factory(Product::class)->make(['amount' => 0])->toArray();

        $this->post('/products', $product)
            ->assertRedirect('/products');
        
        $this->assertStoredWithUnavailableStatus($product);
    }

    /**
     * @test
     */
    public function it_ll_store_a_product_with_not_empty_amount()
    {
        $product = factory(Product::class)->make([
            'amount' => 10
        ])->toArray();

        $this->post('/products', $product)
            ->assertRedirect('/products');

        $this->assertStoredWithAvailableStatus($product);
    }

    /**
     * @test
     */
    public function it_ll_show_a_product()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();

        $this->get('/products/'.$product->id)
            ->assertSuccessful()
            ->assertViewIs('products.show')
            ->assertViewHas('product', $product);
    }

    /**
     * @test
     */
    public function it_ll_show_a_deleted_product()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();

        $product->delete();

        $this->get('/products/'.$product->id)
            ->assertSuccessful()
            ->assertViewIs('products.show')
            ->assertViewHas('product', $product);
    }

    /**
     * @test
     */
    public function it_ll_show_the_edit_product_form()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();

        $this->get('/products/'.$product->id.'/edit')
            ->assertSuccessful()
            ->assertViewIs('products.edit')
            ->assertViewHas('product', $product);
    }

    /**
     * @test
     */
    public function it_ll_update_a_product_to_empty_amount()
    {
        $product = factory(Product::class)->create([
            'amount' => 10,
        ]);

        $updateProductParams = [
            'amount' => 0,
            'value' => $this->faker->randomFloat(0, 100),
            'name' => $this->faker->word,
        ];

        $this->put('/products/'.$product['id'], $updateProductParams)
            ->assertRedirect('/products');

        $this->assertUpdatedToUnavailableStatus($product['id'], $updateProductParams);
    }

    /**
     * @test
     */
    public function it_ll_update_a_product_to_not_empty_amount()
    {
        $product = factory(Product::class)->create([
            'amount' => 0,
        ]);

        $updateProductParams = [
            'amount' => 10,
            'value' => $this->faker->randomFloat(2,0, 100),
            'name' => $this->faker->word,
        ];

        $this->put('/products/'.$product['id'], $updateProductParams)
            ->assertRedirect('/products');

        $this->assertUpdatedToAvailableStatus($product['id'], $updateProductParams);
    }

    /**
     * @test
     */
    public function it_ll_delete_a_product()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();

        $this->delete('/products/'.$product->id)
            ->assertRedirect('/products');

        $this->assertSoftDeleted('products', [
            'id' => $product->id,
        ]);
    }

    private function assertStoredWithUnavailableStatus(array $product)
    {
        $this->assertStoredWithStatus($product, ProductStatus::UNAVAILABLE);
    }

    private function assertStoredWithAvailableStatus(array $product)
    {
        $this->assertStoredWithStatus($product, ProductStatus::AVAILABLE);
    }

    private function assertStoredWithStatus(array $product, string $status)
    {
        $this->assertDatabaseHas('products', [
            'name' => $product['name'],
            'value' => $product['value'],
            'amount' => $product['amount'],
            'status' => $status,
        ]);
    }

    private function assertUpdatedToStatus(int $id, array $product, string $status)
    {
        $this->assertDatabaseHas('products', [
            'id' => $id,
            'name' => $product['name'],
            'value' => $product['value'],
            'amount' => $product['amount'],
            'status' => $status,
        ]);
    }

    private function assertUpdatedToUnavailableStatus(int $id, array $product)
    {
        $this->assertUpdatedToStatus($id, $product, ProductStatus::UNAVAILABLE);
    }

    private function assertUpdatedToAvailableStatus(int $id, array $product)
    {
        $this->assertUpdatedToStatus($id, $product, ProductStatus::AVAILABLE);
    }
}
