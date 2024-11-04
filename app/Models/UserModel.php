<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    // Jika nama tabel tidak mengikuti konvensi, tentukan nama tabel
    protected $table = 'users'; // Ganti dengan nama tabel yang sesuai

    // Jika primary key bukan 'id', tentukan nama primary key
    protected $primaryKey = 'user_id'; // Ganti dengan nama primary key yang sesuai

    // Tentukan atribut yang dapat diisi secara massal
    protected $fillable = [
        'level_id',
        'username',
        'nama',
        'password',
        'created_at',
    ];
    
}
