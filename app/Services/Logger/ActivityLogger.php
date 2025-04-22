<?php

namespace App\Services\Logger;

use App\Models\UserActivity;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class ActivityLogger
{
    public function log(Authenticatable $user, string $activity, Model $subject, string $description = '', array $extra = []): void
    {
        $record = new UserActivity();
        $record->user_id = $user->id;
        $record->action = $activity;
        $record->description = $description;
        $record->subject()->associate($subject);
        $record->extra = json_encode($extra);
        $record->date_time = now();

        $record->save();
    }
}
