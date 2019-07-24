<?php

namespace App\Models;

use App\Exceptions\OrderException;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * @package App\Models
 * @version July 24, 2019, 12:16 am UTC
 *
 * @property Product|null product
 * @property integer id
 * @property integer product_id
 * @property float amount
 * @property float value
 * @property string ordered_at
 * @property string requester_name
 * @property array requester_address
 * @property string forwarding_agent_name
 * @property string status
 */
class Order extends Model
{
    public $table = 'orders';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'product_id',
        'amount',
        'ordered_at',
        'requester_name',
        'requester_address',
        'forwarding_agent_name',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'product_id' => 'integer',
        'amount' => 'float',
        'value' => 'float',
        'requester_name' => 'string',
        'forwarding_agent_name' => 'string',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'product_id' => 'required|integer|exists:products,id',
        'amount' => 'required|numeric|min:0.1',
        'requester_name' => 'required|string|min:2|max:255',
        'requester_address' => 'required|array',
        'requester_address.zipcode' => 'required|string',
        'requester_address.uf' => 'required|string',
        'requester_address.city' => 'required|string',
        'requester_address.address' => 'required|string',
        'requester_address.number' => 'required|string',
        'forwarding_agent_name' => 'required|string|min:1|max:255',
    ];

    protected static function boot()
    {
        self::creating(function (Order $order) {
            $order->setInitialValues();
        });

        self::created(function (Order $order) {
            $order->subtractProductFromStock();
        });

        self::saving(function (Order $order) {
            $order->validateProductAmount();
            $order->convertRequesterAddressToJson();
        });

        self::updated(function (Order $order) {
            $order->handleOlderProduct();
        });

        parent::boot();
    }

    public function getRequesterAddressAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true);
        }

        return $value;
    }

    public function displayRequesterAddress()
    {
        return implode(', ', $this->requester_address);
    }

    public function displayStatus()
    {
        return OrderStatus::$statusMapping[$this->status];
    }

    /**
     * The product related with Order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    private function setValue()
    {
        $this->value = $this->product->value * $this->amount;
    }

    private function setInitialStatus()
    {
        $this->status = OrderStatus::PENDING_SHIPPING;
    }

    private function validateProductAmount()
    {
        if ($this->amount > $this->product->amount) {
            throw OrderException::productNotAvailableInStock();
        }
    }

    private function convertRequesterAddressToJson()
    {
        if (is_array($this->requester_address)) {
            $this->requester_address = json_encode($this->requester_address);
        }
    }

    private function setInitialValues()
    {
        $this->ordered_at = now();
        $this->setValue();
        $this->setInitialStatus();
    }

    private function subtractProductFromStock()
    {
        $product = $this->product;
        $product->amount -= $this->amount;
        $product->save();
    }

    private function handleOlderProduct()
    {
        $olderProductId = $this->getOriginal('product_id');
        $olderOrderAmount = $this->getOriginal('amount');

        /** @var ProductRepository $productRepository */
        $productRepository = app()->make(ProductRepository::class);

        /** @var Product $olderProduct */
        $olderProduct = $productRepository->find($olderProductId);

        $olderProduct->amount += $olderOrderAmount;
        $olderProduct->save();
    }
}
