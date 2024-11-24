<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserDetailModel extends Model
{
    use HasFactory;

    protected $table = 'm_user_detail';
    protected $primaryKey = 'user_detail_id';

    protected $fillable = [
        'user_id',
        'user_detail_nidn',
        'user_detail_nip',
        'user_detail_email',
        'user_detail_phone',
        'user_detail_address',
        'user_detail_image'
    ];

    protected $casts = ['user_detail_id' => 'string'];

    public function user(): HasOne{
        return $this->hasOne(UserModel :: class, 'user_id', 'user_id');
    }
}
