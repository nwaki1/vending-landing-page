<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'category', 'description', 'price', 'specs', 'image', 'status', 'is_featured',
    ];

    protected $casts = [
        'specs'       => 'array',
        'is_featured' => 'boolean',
    ];

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'snack_minuman' => 'Snack & Minuman',
            'kopi_panas'    => 'Kopi & Minuman Panas',
            'atm_beras'     => 'ATM Beras',
            'custom'        => 'VM Custom',
            default         => $this->category,
        };
    }

    public function getCategoryColorAttribute(): string
    {
        return match ($this->category) {
            'snack_minuman' => 'blue',
            'kopi_panas'    => 'amber',
            'atm_beras'     => 'green',
            'custom'        => 'purple',
            default         => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'available'   => 'Tersedia',
            'indent'      => 'Indent',
            'unavailable' => 'Tidak Tersedia',
            default       => $this->status,
        };
    }
}
