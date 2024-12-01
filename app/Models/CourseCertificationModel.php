<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseCertificationModel extends Model
{
    use HasFactory;
    protected $table = 't_course_certification';
    protected $primaryKey = 'course_certification_id';
    protected $fillable = ['certification_id', 'course_id'];
    protected $casts = ['course_id' => 'string'];

    public function certification(): BelongsTo{
        return $this->belongsTo(CertificationModel :: class, 'certification_id', 'certification_id');
    }

    public function course(): BelongsTo{
        return $this->belongsTo(CourseModel :: class, 'course_id', 'course_id');
    }
}
