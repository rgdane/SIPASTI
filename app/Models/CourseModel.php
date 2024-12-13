<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseModel extends Model
{
    use HasFactory;
    protected $table = 'm_course';
    protected $primaryKey = 'course_id';
    protected $fillable = ['course_code', 'course_name'];
    protected $casts = ['course_id' => 'string'];

    public function courseCertification(): BelongsTo{
        return $this->belongsTo(CourseCertificationModel :: class);
    }
    public function courseTraining(): BelongsTo{
        return $this->belongsTo(CourseTrainingModel :: class);
    }
}
