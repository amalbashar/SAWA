<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    use HasFactory;

    protected $guarded = ['patient_id'];

    public function user()
{
    return $this->belongsTo(User::class, 'patient_id');
}

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
}
