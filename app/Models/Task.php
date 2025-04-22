<?php

namespace App\Models;

use App\Enums\PriorityEnum;
use App\Enums\TaskStatus;
use App\Observers\TaskObserver;
use App\Services\Filters\SimpleQueryFilter\Filterable;
use App\Services\Sorters\Sortable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([TaskObserver::class])]
class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory, Filterable, Sortable;

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class)->withPivot('role');
    }

    public function scopeGetTaskForUser(Builder $builder, Authenticatable $user): Builder
    {
        return $builder->whereHas('collaborators', fn (Builder $query) =>
            $query->where('user_id', $user->id))
                ->orWhere('owner_id',$user->id);
    }

    public function scopeGetOverdue(Builder $builder): Builder
    {
        return $builder->whereDate('due_date', '<', now())
            ->whereNotIn('status', [TaskStatus::Overdue->value, TaskStatus::Done->value]);
    }

    public function scopeGetByPriority(Builder $builder, PriorityEnum $priority): Builder
    {
        return $builder->where('priority',$priority->value);
    }

    public function scopeGetTasksDueInNext(Builder $builder, int $minutes): Builder
    {
        $from = now();
        $to = now()->copy()->addMinutes($minutes);

        return $builder->whereBetween('due_date', [$from, $to]);
    }

}
