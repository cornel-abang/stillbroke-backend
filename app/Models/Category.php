<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $image
 * @property HasMany<Product> $products
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
