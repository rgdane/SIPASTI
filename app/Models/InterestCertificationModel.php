<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterestCertificationModel extends Model
{
    use HasFactory;
    protected $table = 't_interest_certification';
    protected $primaryKey = 'interest_certification_id';
    protected $fillable = ['certification_id', 'interest_id'];
    protected $casts = ['interest_id' => 'string'];

    public function certification(): BelongsTo{
        return $this->belongsTo(CertificationModel :: class, 'certification_id', 'certification_id');
    }

    public function interest(): BelongsTo{
        return $this->belongsTo(InterestModel :: class, 'interest_id', 'interest_id');
    }
}
