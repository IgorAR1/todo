<?php

namespace App\Services\Filters\QueryFilter;

use App\Contracts\Filter;
use App\Services\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

final class QueryFilterExact implements FilterInterface
{
    public function filter(Builder $builder,string $property ,array $values): void
    {
        foreach ($values as $value) {
            $builder->where($property, $value);
        }
    }
}
