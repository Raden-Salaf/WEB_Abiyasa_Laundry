<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes; // tabel customer punya kolom deleted_at

    protected $table = 'customer'; // nama tabel asli (singular)

    protected $fillable = [
        'customer_name',
        'phone',
        'address',
    ];

    // Relasi: satu customer bisa punya banyak transaksi order
    public function transOrders()
    {
        return $this->hasMany(TransOrder::class, 'id_customer');
    }

    // Relasi: satu customer bisa punya banyak riwayat pengambilan laundry
    public function transLaundryPickups()
    {
        return $this->hasMany(TransLaundryPickup::class, 'id_customer');
    }
}