<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function careProvider()
    {
        return $this->belongsTo(CareProviderProfile::class);
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}
