<?php

namespace App\Services\Filters\SimpleQueryFilter;

use App\Services\Filters\FilterInterface;
use App\Services\Filters\QueryFilter\InvalidFilter;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(Builder $builder, SimpleQueryFilter $filter):Builder
    {
        $filter->apply($builder);

        return $builder;
    }
}
