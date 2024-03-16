<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property int $user_id
 * @property int $amount
 * @property string $payment_ref
 * @property string $receipt_url
 * @property string $shipping_address
 * @property string $shipping_phone
 * @property string $gateway
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'amount',
        'payment_ref',
        'receipt_url',
        'shipping_address',
        'shipping_phone',
        'gateway'
    ];

    protected $with = ['items'];

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, OrderProduct::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
