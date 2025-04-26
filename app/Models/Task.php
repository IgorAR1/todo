<?php

namespace App\Models;

use App\Enums\PriorityEnum;
use App\Enums\TaskStatus;
use App\Observers\TaskObserver;
use App\Queries\TaskQuery;
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

    protected $casts = [
        'due_date' => 'datetime',
    ];

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

    public function setCollaborators(array $shares): void
    {
        $this->collaborators()->sync($shares);

    }

    public function activities()
    {
        return $this->morphMany(UserActivity::class, 'subject');
    }

    public function newEloquentBuilder($query): Builder
    {
        return new TaskQuery($query);
    }
}
