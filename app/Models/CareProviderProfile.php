<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareProviderProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'bio',
        'offers_home_services',
        'clinic_address','profile_image',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consultationsResponded()
    {
        return $this->hasMany(Consultation::class, 'responded_by'); // الاستشارات التي رد عليها مقدم الرعاية
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
    public function bookings()
{
    return $this->hasMany(Booking::class);
}
public function advice()
{
    return $this->hasMany(Advice::class);
}

}
