<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['title', 'subtitle', 'cta_text', 'cta_url', 'image', 'order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
