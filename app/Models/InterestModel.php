<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterestModel extends Model
{
    use HasFactory;
    protected $table = 'm_interest';
    protected $primaryKey = 'interest_id';
    protected $fillable = ['interest_code', 'interest_name'];
    protected $casts = ['interest_id' => 'string'];

    public function interestCertification(): BelongsTo{
        return $this->belongsTo(InterestCertificationModel :: class);
    }
    public function interestTraining(): BelongsTo{
        return $this->belongsTo(InterestTrainingModel :: class);
    }
}
