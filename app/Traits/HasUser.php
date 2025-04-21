<?php

namespace App\Traits;

use Illuminate\Contracts\Auth\Authenticatable;

trait HasUser
{
    private function resolveUser(): Authenticatable
    {
        return auth()->user();
    }
}
