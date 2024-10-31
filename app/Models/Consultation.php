<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function respondedBy()
    {
        return $this->belongsTo(CareProviderProfile::class, 'responded_by'); // العلاقة الجديدة مع الشخص الذي قام بالرد
    }

    public function medicalHistory()
    {
        return $this->belongsTo(MedicalHistory::class, 'medical_history_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
