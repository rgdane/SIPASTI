<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificationVendorModel extends Model
{
    use HasFactory;

    protected $table = 'm_certification_vendor';
    protected $primaryKey = 'certification_vendor_id';
    protected $casts = [
        'certification_vendor_id' => 'string',
    ];
    protected $fillable = [
        'certification_vendor_name',
        'certification_vendor_address',
        'certification_vendor_city',
        'certification_vendor_phone',
        'certification_vendor_web'
    ];

    public function certification(): BelongsTo{
        return $this->belongsTo(CertificationModel :: class);
    }
}
