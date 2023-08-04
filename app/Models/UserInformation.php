<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'ext_name',
        'mobile_number',
        'designation',
        'office_id',
        'position_id',
        'user_image_file',
        'user_id',
    ];
}
