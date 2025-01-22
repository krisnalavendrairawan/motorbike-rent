<?php

namespace App\Enums;

enum BikeType: string
{
    case Matic = 'automatic';
    case Manual = 'manual';
    case Electric = 'electric';
}
