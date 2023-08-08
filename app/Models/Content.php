<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = ['name', 'week', 'image', 'title', 'description', 'stage_id'];

    public function stages()
    {
        return $this->belongsTo(Stage::class);
    }
}
