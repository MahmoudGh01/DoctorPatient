<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /** @use HasFactory<\Database\Factories\AppointmentFactory> */
    use HasFactory;
    protected $guarded = [];

    public function cabinet()
    {
        return $this->belongsTo(Cabinet::class);
    }

    public function patient(){
        return $this->belongsTo(User::class);
    }
}
