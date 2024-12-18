<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory;
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';

    protected $fillable = ['user_type_id', 'user_fullname', 'username', 'password'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed', 'user_id' => 'string']; //casting password agar otomatis dihash

    public function user_type(): BelongsTo {
        return $this->belongsTo(UserTypeModel::class, 'user_type_id', 'user_type_id');
    }

    public function user_detail()
    {
        return $this->hasOne(UserDetailModel::class, 'user_id', 'user_id');
    }

    public function certification(): BelongsTo{
        return $this->belongsTo(CertificationModel :: class);
    }
    
    public function trainingMember(): BelongsTo{
        return $this->belongsTo(TrainingMemberModel :: class);
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