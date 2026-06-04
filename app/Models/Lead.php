<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name', 'whatsapp', 'email', 'need', 'message', 'source', 'status',
    ];

    public function getNeedLabelAttribute(): string
    {
        return match ($this->need) {
            'beli'    => 'Beli Unit Baru',
            'sewa'    => 'Sewa Unit',
            'info'    => 'Informasi Produk',
            'service' => 'Servis / Perawatan',
            default   => $this->need,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'new'       => 'Baru',
            'contacted' => 'Dihubungi',
            'closed'    => 'Selesai',
            default     => $this->status,
        };
    }
}
