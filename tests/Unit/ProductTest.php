<?php

namespace Tests\Unit;

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
    public function it_should_set_unavailable_status_when_save_with_empty_amount()
    {
        $product = new Product([
            'name' => $this->faker->word,
            'value' => $this->faker->randomFloat(2, 0, 100),
            'amount' => 0,
        ]);

        $product->save();

        $this->assertEquals(ProductStatus::UNAVAILABLE, $product->status);
    }

    /**
     * @test
     */
    public function it_should_set_available_status_when_save_with_positive_amount()
    {
        $product = new Product([
            'name' => $this->faker->word,
            'value' => $this->faker->randomFloat(2, 0, 100),
            'amount' => 1,
        ]);

        $product->save();

        $this->assertEquals(ProductStatus::AVAILABLE, $product->status);
    }
}
