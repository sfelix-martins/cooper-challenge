<?php

namespace Tests\Traits;

use App\Models\Product;
use App\Models\ProductStatus;

trait HasOrderAsserts
{
    private function assertProductSubtractedFromStock(Product $product, int $subtractedAmount)
    {
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'amount' => $product->amount - $subtractedAmount,
        ]);
    }

    private function assertProductWithUnavailableStatus($product)
    {
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'status' => ProductStatus::UNAVAILABLE,
        ]);
    }
}
