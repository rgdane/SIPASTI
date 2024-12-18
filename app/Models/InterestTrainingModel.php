<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterestTrainingModel extends Model
{
    use HasFactory;
    protected $table = 't_interest_training';
    protected $primaryKey = 'interest_training_id';
    protected $fillable = ['training_id', 'interest_id'];
    protected $casts = ['interest_id' => 'string'];

    public function training(): BelongsTo{
        return $this->belongsTo(TrainingModel :: class, 'training_id', 'training_id');
    }

    public function interest(): BelongsTo{
        return $this->belongsTo(InterestModel :: class, 'interest_id', 'interest_id');
    }
}
