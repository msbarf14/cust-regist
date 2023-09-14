<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $table = 'forms';
    protected $fillable = [
        'store_name',
        'store_image',
        'ktp_image',
        'address',
        'orders',
    ];

    protected $casts = [
        'orders' => 'json'
    ];
}
