<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Volume extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_volume',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('nama_volume', 'like', '%' . $search . '%');
        });
    }

    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class);
    }
}
