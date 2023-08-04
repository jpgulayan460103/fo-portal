<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneTimePassword extends Model
{
    use HasFactory;

    protected $fillable = [
        'otp_code',
        'reference_number',
        'user_id',
    ];

    protected $hidden = [
        'otp_code',
    ];
}
