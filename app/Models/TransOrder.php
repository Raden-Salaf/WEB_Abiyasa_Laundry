<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransOrder extends Model
{
    use HasFactory, SoftDeletes; // tabel trans_order punya kolom deleted_at

    protected $table = 'trans_order'; // nama tabel asli (singular)

    protected $fillable = [
        'id_customer',
        'order_code',
        'order_date',
        'order_end_date',
        'order_status', // 0 = baru, 1 = sudah diambil (sesuai alur di dokumentasi)
        'order_pay',
        'order_change',
        'total',
    ];

    // Relasi: satu transaksi order dimiliki oleh satu customer (termasuk yang di-soft-delete)
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer')->withTrashed();
    }

    // Relasi: satu transaksi order bisa punya banyak detail jasa (item laundry)
    public function details()
    {
        return $this->hasMany(TransOrderDetail::class, 'id_order');
    }

    // Relasi: satu transaksi order bisa punya data pengambilan (saat sudah diambil)
    public function pickup()
    {
        return $this->hasOne(TransLaundryPickup::class, 'id_order');
    }
}