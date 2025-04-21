<?php

namespace App\Services\Filters\QueryFilter;

use App\Services\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;


class FieldFilter
{
    private FilterInterface $filter;
    private string $name;
    public function __construct(FilterInterface $filter, string $name)
    {
        $this->filter = $filter;
        $this->name = $name;
    }

    public function execute(Builder $builder,string $values): void
    {
        $values = $this->resolveQueryValues($values);

        $this->filter->filter($builder,$this->name,$values);
    }

    private function resolveQueryValues(string $values): array
    {
        return explode(',',$values);
    }

}
