<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificationModel extends Model
{
    use HasFactory;
    protected $table = 'm_certification';
    protected $primaryKey = 'certification_id';
    protected $casts = [
        'certification_id' => 'string',
    ];
    protected $fillable = [
        'certification_name',
        'certification_number',
        'certification_date_start',
        'certification_date_expired',
        'certification_vendor_id',
        'certification_level',
        'certification_type',
        'certification_file',
        'user_id'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    public function certificationVendor(): BelongsTo {
        return $this->belongsTo(CertificationVendorModel::class, 'certification_vendor_id', 'certification_vendor_id');
    }
}