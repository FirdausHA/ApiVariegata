<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'transaction_code',
        'comment',
        'rating',
    ];

    // Definisikan relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Definisikan relasi dengan model Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
