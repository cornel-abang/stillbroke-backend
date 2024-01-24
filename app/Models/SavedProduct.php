<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $product_id
 * @property string $user_id
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class SavedProduct extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','user_id'];
}
