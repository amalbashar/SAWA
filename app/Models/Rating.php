<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $guarded = ['user_id', 'care_provider_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function careProvider()
    {
        return $this->belongsTo(CareProviderProfile::class);
    }
}

