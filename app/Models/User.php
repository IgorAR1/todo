<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class,'owner_id');//TODO убрать нгхуй owner_id
    }

    public function collaborationTasks()
    {
        return $this->belongsToMany(Task::class)->withPivot('role');
    }

    public function hasPermissionsForTask(Task $task, string $ability): bool
    {
        if ($this->isOwner($task)) {
            return true;
        }

        if ($this->isCollaborator($task)) {
            $role = $this->getRole($task);
            return in_array($ability, config('permissions.roles.'.$role, []));
        }

        return false;
    }

    public function getRole(Task $task): string
    {

        return $this->collaborationTasks()
            ->firstWhere('task_id',$task->id)
            ->pivot
            ->role;
    }
    public function isOwner(Task $task): bool
    {
        return $this->id === $task->owner_id;
    }

    public function isCollaborator(Task $task): bool
    {
        return $this->collaborationTasks()
            ->where('task_id',$task->id)
            ->exists();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


}
