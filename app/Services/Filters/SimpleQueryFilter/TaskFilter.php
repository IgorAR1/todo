<?php

namespace App\Services\Filters\SimpleQueryFilter;


use Illuminate\Database\Eloquent\Builder;

class TaskFilter extends SimpleQueryFilter
{
    protected function title(Builder $builder, array $values): void
    {
        foreach ($values as $value) {
            $builder->where('title', 'LIKE',$value.'%');
        }
    }

    protected function tags(Builder $builder, array $values): void
    {
        foreach ($values as $value) {
            $builder->whereHas('tags', fn(Builder $q) => $q->where('name', $value));
        }
    }

    protected function description(Builder $builder, array $values): void
    {
        foreach ($values as $value) {
            $builder->where('description', 'LIKE','%'.$value.'%');
        }
    }
}
