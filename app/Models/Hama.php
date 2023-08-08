<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hama extends Model
{
    protected $fillable = ['name', 'tipe', 'image', 'description', 'cegah', 'plant_id'];

    public function plants()
    {
        return $this->belongsTo(Plant::class);
    }
}
