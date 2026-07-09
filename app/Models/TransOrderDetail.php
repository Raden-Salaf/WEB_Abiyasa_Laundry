<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransOrderDetail extends Model
{
    use HasFactory; // tabel ini tidak punya deleted_at, jadi tidak pakai SoftDeletes

    protected $table = 'trans_order_detail'; // nama tabel asli (singular)

    protected $fillable = [
        'id_order',
        'id_service',
        'qty',
        'subtotal', // hasil perhitungan: harga jasa * qty
        'notes',
    ];

    // Relasi: satu detail dimiliki oleh satu transaksi order (header) (termasuk yang di-soft-delete)
    public function order()
    {
        return $this->belongsTo(TransOrder::class, 'id_order')->withTrashed();
    }

    // Relasi: satu detail menggunakan satu jenis jasa (termasuk yang di-soft-delete)
    public function service()
    {
        return $this->belongsTo(TypeOfService::class, 'id_service')->withTrashed();
    }
}