<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $amount
 * @property string $payment_ref
 * @property string $receipt_url
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
    ];
}
