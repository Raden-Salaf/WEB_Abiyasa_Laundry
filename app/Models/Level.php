<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use HasFactory, SoftDeletes; // SoftDeletes karena tabel level punya kolom deleted_at

    protected $table = 'level'; // nama tabel asli (singular, sesuai ERD)

    protected $fillable = [
        'level_name', // kolom yang boleh diisi lewat mass assignment
    ];

    // Relasi: satu level bisa dimiliki banyak user
    public function users()
    {
        return $this->hasMany(User::class, 'id_level');
    }
}