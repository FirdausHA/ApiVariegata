<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCrosell extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'price', 'image', 'stock', 'expiry_time'
    ];
}