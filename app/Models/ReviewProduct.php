<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewProduct extends Model
{
    use HasFactory;

    protected $fillable = ['user_name', 'comment', 'rating', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
