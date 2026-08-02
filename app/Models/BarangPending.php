<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangPending extends Model
{
    use HasFactory;

    protected $fillable = [
        'tgl_pending',
        'no_transaksi',
        'pelanggan_id',
        'total_qty',
        'total_harga',
        'keterangan',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(BarangPendingDetail::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('no_transaksi', 'like', '%' . $search . '%')
                ->orWhere('tgl_pending', 'like', '%' . $search . '%')
                ->orWhereHas('pelanggan', function ($q) use ($search) {
                    $q->where('nama_pelanggan', 'like', '%' . $search . '%');
                });
        });
    }
}
