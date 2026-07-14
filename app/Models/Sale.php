<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    /**
     * Properti yang dapat diisi secara massal.
     */
   protected $fillable = [
    'invoice_number',
    'customer_name',
    'total_price',
    'discount',
    'grand_total',
    'user_id',
];
    /**
     * Relasi: Transaksi ini dibuat/dilayani oleh user (Kasir) tertentu.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Satu invoice penjualan bisa memiliki banyak item/rincian barang tercetak.
     */
    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}