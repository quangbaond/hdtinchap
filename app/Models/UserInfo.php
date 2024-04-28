<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cccd', // Add this line
        'fullname',
        'birthday',
        'image_front',
        'image_back',
        'image_selfie',
        'address',
        'status'
    ];
}
