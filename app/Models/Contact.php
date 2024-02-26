<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $message
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'message'];
}
