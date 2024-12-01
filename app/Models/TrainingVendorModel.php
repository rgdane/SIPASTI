<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingVendorModel extends Model
{
    use HasFactory;

    protected $table = 'm_training_vendor';
    protected $primaryKey = 'training_vendor_id';
    protected $casts = [
        'training_vendor_id' => 'string',
    ];
    protected $fillable = [
        'training_vendor_name',
        'training_vendor_address',
        'training_vendor_city',
        'training_vendor_phone',
        'training_vendor_web'
    ];

    public function training(): BelongsTo{
        return $this->belongsTo(TrainingModel :: class);
    }
}
