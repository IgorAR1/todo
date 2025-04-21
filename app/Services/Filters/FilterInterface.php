<?php

namespace App\Services\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function filter(Builder $builder,string $property ,array $values): void;
}
