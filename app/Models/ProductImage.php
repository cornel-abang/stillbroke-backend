<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property string $url
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'url'];
}
