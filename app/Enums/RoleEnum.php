<?php

namespace App\Enums;

enum RoleEnum:string
{
    case Owner = 'owner';
    case Editor = 'editor';
    case Viewer = 'viewer';
}
