<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = ['name','banner_id'];

    public function banners()
    {
        return $this->belongsTo(Banner::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
