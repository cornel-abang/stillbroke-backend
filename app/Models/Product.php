<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Freshbitsweb\LaravelCartManager\Traits\Cartable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $title
 * @property integer $price
 * @property string $category_id
 * @property string $description
 * @property string $color
 * @property string $primary_image
 * @property BelongsTo<Category> $category
 * @property HasMany<ProductImage> $images
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class Product extends Model
{
    use HasFactory, Searchable, Cartable;

    protected $with = ['images'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getName()
    {
        return $this->attributes['title'];
    }

    public function getImage()
    {
        return $this->attributes['primary_image'];;
    }
}
