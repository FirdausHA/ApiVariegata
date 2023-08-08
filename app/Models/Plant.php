<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    protected $fillable = ['name', 'scientific', 'image_bg', 'image'];

    public function plant_stages()
    {
        return $this->hasMany(PlantStage::class);
    }

    public function hamas()
    {
        return $this->hasMany(Hama::class);
    }
}
