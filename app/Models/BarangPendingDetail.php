<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangPendingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_pending_id',
        'barang_id',
        'qty',
        'harga',
        'total_harga',
    ];

    public function barangPending(): BelongsTo
    {
        return $this->belongsTo(BarangPending::class);
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}
