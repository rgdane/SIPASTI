<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    protected $fillable = ['user_type_id', 'username', 'password'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed']; //casting password agar otomatis dihash

    public function user_type(): BelongsTo {
        return $this->belongsTo(UserTypeModel::class, 'user_type_id', 'user_type_id');
    }

    public function getRoleName(): string{
        return $this->user_type->user_type_name;
    }

    public function hasRole($role): bool{
        return $this->user_type->user_type_code == $role;
    }

    public function getRole(){
        return $this->user_type->user_type_code;
    }
}