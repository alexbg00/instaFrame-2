<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';

    public function image()
    {
        return $this->belongsTo('App\Models\Image');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
