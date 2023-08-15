<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'subtitle', 'image', 'color','plant_id'];

    public function plants()
    {
        return $this->belongsTo(Plant::class);
    }

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }
}
