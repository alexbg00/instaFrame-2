<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    public function image()
    {
        return $this->belongsTo('App\Models\Image');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
