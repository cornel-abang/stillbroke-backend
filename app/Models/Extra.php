<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property string $value
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class Extra extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'name', 'value'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
