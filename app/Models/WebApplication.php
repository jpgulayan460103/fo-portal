<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'application_name',
        'application_url',
        'application_image',
        'application_description',
        'keywords',
    ];

    public function getApplicationImageAttribute($value)
    {
        return url($value);
    }
}
