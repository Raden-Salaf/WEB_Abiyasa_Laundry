<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransLaundryPickup extends Model
{
    use HasFactory; // tabel ini tidak punya deleted_at, jadi tidak pakai SoftDeletes

    protected $table = 'trans_laundry_pickup'; // nama tabel asli (singular)

    protected $fillable = [
        'id_order',
        'id_customer',
        'pickup_date',
        'notes',
    ];

    // Relasi: satu data pengambilan terkait dengan satu transaksi order (termasuk yang di-soft-delete)
    public function order()
    {
        return $this->belongsTo(TransOrder::class, 'id_order')->withTrashed();
    }

    // Relasi: satu data pengambilan terkait dengan satu customer (termasuk yang di-soft-delete)
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer')->withTrashed();
    }
}