<?php

namespace App\Enums;

enum TaskStatus: string {
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Done = 'done';
    case Overdue = 'overdue';
    case Canceled = 'canceled';
    case Archived = 'archived';
}
