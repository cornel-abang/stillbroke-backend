<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property int $order_id
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 
        'order_id',
    ];
}
