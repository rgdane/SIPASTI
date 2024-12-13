<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingMemberModel extends Model
{
    use HasFactory;
    protected $table = 't_training_member';
    protected $primaryKey = 'training_member_id';
    protected $fillable = ['training_id', 'user_id'];
    protected $casts = ['user_id' => 'string'];

    public function training(): BelongsTo{
        return $this->belongsTo(TrainingModel :: class, 'training_id', 'training_id');
    }

    public function interest(): BelongsTo{
        return $this->belongsTo(UserModel :: class, 'user_id', 'user_id');
    }
}
