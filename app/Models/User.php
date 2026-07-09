<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Tidak perlu $table lagi, karena sekarang pakai tabel bawaan 'users' (plural)
    // Eloquent otomatis menebak nama tabel dari nama Model, jadi tidak perlu didefinisikan manual

    protected $fillable = [
        'id_level', // relasi ke tabel level, sesuai ERD
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token', // kolom bawaan Laravel, ikut disembunyikan juga
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // kolom bawaan Laravel
            'password' => 'hashed',
        ];
    }

    // Relasi: satu user dimiliki oleh satu level (Admin/Operator/Pimpinan)
    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level');
    }
}