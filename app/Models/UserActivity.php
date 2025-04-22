<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserActivity extends Model
{
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
}
