<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $about
 * @property string $terms
 * @property string $privacy
 * @property string $video
 * @property string $featured_txt
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'about', 'terms', 
        'privacy', 'video'
    ];
}
