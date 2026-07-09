<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeOfService extends Model
{
    use HasFactory, SoftDeletes; // tabel type_of_service punya kolom deleted_at

    protected $table = 'type_of_service'; // nama tabel asli (singular)

    protected $fillable = [
        'service_name',
        'price',
        'description',
    ];

    // Relasi: satu jenis jasa bisa dipakai di banyak detail transaksi
    public function transOrderDetails()
    {
        return $this->hasMany(TransOrderDetail::class, 'id_service');
    }
}