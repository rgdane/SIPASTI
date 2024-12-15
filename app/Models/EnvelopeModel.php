<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvelopeModel extends Model
{
    use HasFactory;

    protected $table = 't_envelope';
    protected $primaryKey = 'envelope_id';
    protected $fillable = ['training_id', 'envelope_file'];
    protected $casts = ['envelope_id' => 'string'];

    public function training(){
        return $this->belongsTo(TrainingModel::class, 'training_id', 'training_id');
    }
}
