<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'customer_email' => $this->customer_email,
            'customer_phone_number' => $this->customer_phone_number,
            'health_professional_id' => $this->health_professional_id,
            'service_id' => $this->service_id,
            'start_date_time' => $this->start_date_time,
            'end_date_time' => $this->end_date_time,
            'confirmed' => $this->confirmed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
