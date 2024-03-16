<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property int $video_url
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class Vlog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'video_url'];
}
