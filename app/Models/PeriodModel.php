<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeriodModel extends Model
{
    use HasFactory;
    protected $table = 'm_period';
    protected $primaryKey = 'period_id';
    protected $fillable = ['period_year'];
    protected $casts = ['period_id' => 'string'];

    public function certification(): BelongsTo{
        return $this->belongsTo(CertificationModel :: class);
    }
    
    public function training(): BelongsTo{
        return $this->belongsTo(TrainingModel :: class);
    }
}
