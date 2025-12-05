<?php

namespace App\Models;

use Database\Factories\HealthProfessionalFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthProfessional extends Model
{
    /** @use HasFactory<HealthProfessionalFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'type',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
