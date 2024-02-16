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
 * @property string $gender
 * @property string $primary_image
 * @property bool $featured
 * @property bool $discounted
 * @property int $duration
 * @property int $percentage
 * @property BelongsTo<Category> $category
 * @property HasMany<ProductImage> $images
 * @property HasMany<ProductSize> $sizes
 * @property HasMany<ProductColor> $colors
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class Product extends Model
{
    use HasFactory, Searchable, Cartable;

    protected $fillable = [
        'title', 
        'price', 
        'category_id', 
        'description', 
        'gender', 
        'primary_image',
        'discounted',
        'duration',
        'percentage',
    ];

    protected $with = ['images', 'colors', 'sizes'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function sizes(): HasMany
    {
        return $this->hasMany(ProductSize::class);
    }

    public function colors(): HasMany
    {
        return $this->hasMany(ProductColor::class);
    }

    public function getName()
    {
        return $this->attributes['title'];
    }

    public function getImage()
    {
        return $this->attributes['primary_image'];
    }

    public function makeFeatured(): bool
    {
        $this->attributes['featured'] = true;

        return $this->save();
    }

    public function makeUnfeatured(): bool
    {
        $this->attributes['featured'] = false;
        
        return $this->save();
    }

    public function discount(int $percentage, int $duration): bool
    {
        $this->attributes['discounted'] = true;
        $this->attributes['percentage'] = $percentage;
        $this->attributes['duration'] = $duration;
        
        return $this->save();
    }

    public function updateDiscount(array $data)
    {
        return $this->update($data);
    }

    public function removeDiscount(): bool
    {
        $this->attributes['discounted'] = false;
        $this->attributes['percentage'] = 0;
        $this->attributes['duration'] = 0;
        
        return $this->save();
    }
}
