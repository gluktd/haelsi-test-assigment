<?php

namespace App\Enums;

enum AppointmentTypeEnum: string
{
    case INITIAL = 'initial';
    case FOLLOW_UP = 'follow_up';
    case CONTROL = 'control';
    case EMERGENCY = 'emergency';
    public function getLabel(): string
    {
        return match ($this) {
            self::FOLLOW_UP => 'Follow Up',
            default => ucfirst($this->value),
        };
    }
}
