<?php

namespace App\Services\Filters\QueryFilter;

use App\Contracts\Filter;
use Illuminate\Database\Eloquent\Builder;

final class QueryFilterExact implements Filter
{
    public function filter(Builder $builder,string $property ,array $values): void
    {
        foreach ($values as $value) {
            $builder->where($property, $value);
        }
    }
}
