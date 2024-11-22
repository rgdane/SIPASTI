<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTypeModel extends Model
{
    use HasFactory;
    
    protected $table = 'm_user_type';
    protected $primaryKey = 'user_type_id';
    protected $casts = [
        'user_type_id' => 'string',
    ];
    protected $fillable = ['user_type_code', 'user_type_name'];

    public function user(): BelongsTo{
        return $this->belongsTo(UserModel :: class);
    }
}