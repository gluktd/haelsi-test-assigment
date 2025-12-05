<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    /** @use HasFactory<\Database\Factories\AppointmentFactory> */
    use HasFactory;

    protected $fillable = [
        'uuid',
        'customer_email',
        'customer_phone_number',
        'health_professional_id',
        'service_id',
        'start_date_time',
        'end_date_time',
        'confirmed',
    ];

    protected $casts = [
        'confirmed' => 'boolean',
        'start_date_time' => 'datetime',
        'end_date_time' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function healthProfessional(): BelongsTo
    {
        return $this->belongsTo(HealthProfessional::class);
    }
}
