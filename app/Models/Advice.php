<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advice extends Model
{
    protected $guarded = [];

    // ربط النصيحة بملف مقدم الرعاية
    public function careProviderProfile()
    {
        return $this->belongsTo(CareProviderProfile::class);
    }
}
