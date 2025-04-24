<?php

namespace App\Traits;

use Illuminate\Contracts\Auth\Authenticatable;

trait InteractWithUser
{
    private function resolveUser(): Authenticatable
    {
        return auth()->user();
    }
}
