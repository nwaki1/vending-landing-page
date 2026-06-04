<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['name', 'position', 'rating', 'content', 'photo', 'is_published'];

    protected $casts = ['is_published' => 'boolean'];
}
