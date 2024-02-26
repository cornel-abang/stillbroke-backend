<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $email
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class Newsletter extends Model
{
    use HasFactory;

    protected $fillable = ['email'];
}
