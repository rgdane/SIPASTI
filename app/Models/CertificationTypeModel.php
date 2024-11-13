<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificationTypeModel extends Model
{
    use HasFactory;

    protected $table = 'm_certification_type';
    protected $primaryKey = 'certification_type_id';
    protected $casts = [
        'certification_type_id' => 'string',
    ];
    protected $fillable = ['certification_type_code', 'certification_type_name'];
}
