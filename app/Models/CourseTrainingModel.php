<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseTrainingModel extends Model
{
    use HasFactory;
    protected $table = 't_course_training';
    protected $primaryKey = 'course_training_id';
    protected $fillable = ['training_id', 'course_id'];
    protected $casts = ['course_id' => 'string'];

    public function training(): BelongsTo{
        return $this->belongsTo(TrainingModel :: class, 'training_id', 'training_id');
    }

    public function course(): BelongsTo{
        return $this->belongsTo(CourseModel :: class, 'course_id', 'course_id');
    }
}
