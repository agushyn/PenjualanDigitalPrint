<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    /**
     * Properti yang dapat diisi secara massal.
     */
    protected $fillable = [
        'sale_id',
        'item_name',
        'machine',
        'qty',
        'price',
        'subtotal',
        'status',
        'file_path',
        'notes',
    ];

    /**
     * Relasi: Rincian barang ini merujuk pada sebuah invoice induk.
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }
}