<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'address',
        'receiver_name',
        'receiver_phone',
        'email',
        'driver_note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
