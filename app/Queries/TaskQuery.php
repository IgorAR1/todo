<?php

namespace App\Queries;

use App\Enums\PriorityEnum;
use App\Enums\TaskStatus;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;

class TaskQuery extends Builder
{
    public function forUser(Authenticatable $user): static
    {
        return $this->whereHas('collaborators',
            fn(Builder $query) => $query->where('user_id', $user->id)
        )
            ->orWhere('owner_id', $user->id)
            ->with('collaborators', 'tags');
    }

    public function overdue(): Builder
    {
        return $this->whereDate('due_date', '<', now())
            ->whereNotIn('status', [TaskStatus::Overdue->value, TaskStatus::Done->value])
            ->with('owner');
    }

    public function byPriority(PriorityEnum $priority): static
    {
        return $this->where('priority', $priority->value);
    }

    public function dueInNext(int $minutes): static
    {
        $from = now();
        $to = now()->copy()->addMinutes($minutes);

        return $this->whereBetween('due_date', [$from, $to])->with('owner');
    }
}
