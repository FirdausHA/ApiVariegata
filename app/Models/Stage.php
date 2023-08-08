<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = ['name', 'subtitle', 'image', 'color','plant_id'];

    public function plants()
    {
        return $this->belongsTo(Plant::class);
    }
}
