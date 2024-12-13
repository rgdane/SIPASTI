<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingModel extends Model
{
    use HasFactory;
    protected $table = 'm_training';
    protected $primaryKey = 'training_id';
    protected $casts = [
        'training_id' => 'string',
    ];
    protected $fillable = [
        'training_name',
        'period_id',
        'training_date',
        'training_hours',
        'training_location',
        'training_cost',
        'training_vendor_id',
        'training_level',
        'training_quota',
        'training_status'
    ];

    public function period(): BelongsTo {
        return $this->belongsTo(PeriodModel::class, 'period_id', 'period_id');
    }

    public function trainingVendor(): BelongsTo {
        return $this->belongsTo(TrainingVendorModel::class, 'training_vendor_id', 'training_vendor_id');
    }

    public function courseTraining(): BelongsTo{
        return $this->belongsTo(CourseTrainingModel :: class);
    }

    public function interestTraining(): BelongsTo{
        return $this->belongsTo(InterestTrainingModel :: class);
    }

    public function trainingMember(): BelongsTo{
        return $this->belongsTo(TrainingMemberModel :: class);
    }
}
