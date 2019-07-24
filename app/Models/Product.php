<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * @package App\Models
 * @version July 23, 2019, 8:13 pm UTC
 *
 * @property int $id
 * @property string name
 * @property float value
 * @property int amount
 * @property string status
 */
class Product extends Model
{
    use SoftDeletes;

    public $table = 'products';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'value',
        'amount',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'value' => 'float',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'string|required|max:255',
        'value' => 'numeric|required|min:0',
        'amount' => 'integer|required|min:0',
    ];

    /**
     * @inheritDoc
     */
    protected static function boot()
    {
        parent::boot();

        self::saving(function (Product $product) {
            $product->setAvailability();
        });
    }

    /**
     * Set the availability of the product based on amount.
     *
     * @return void
     */
    private function setAvailability(): void
    {
        if ($this->amount == 0) {
            $this->status = ProductStatus::UNAVAILABLE;
            return;
        }

        $this->status = ProductStatus::AVAILABLE;
    }
}
