<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    protected $fillable = ['name', 'scientific', 'image', 'image_bg'];

    public function banners()
    {
        return $this->hasMany(Banner::class);
    }

    public function hamas()
    {
        return $this->hasMany(Hama::class);
    }
}
