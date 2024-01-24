<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property int $user_id
 * @property string $email
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class VerificationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'user_id',
        'email'
    ];
}
