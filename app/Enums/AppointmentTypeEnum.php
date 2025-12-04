<?php

namespace App\Enums;

enum AppointmentTypeEnum: string
{
    case INITIAL = 'initial';
    case FOLLOW_UP = 'follow_up';
    case CONTROL = 'control';
    case EMERGENCY = 'emergency';
    case TELEMEDICINE = 'telemedicine';
}
