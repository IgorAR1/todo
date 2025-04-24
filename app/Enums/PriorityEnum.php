<?php

namespace App\Enums;

use Illuminate\Contracts\Support\Arrayable;

enum PriorityEnum:int
{
    case High = 3;
    case Medium = 2;
    case Low = 1;
}
