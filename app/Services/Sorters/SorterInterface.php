<?php

namespace App\Services\Sorters;

use Illuminate\Database\Eloquent\Builder;

interface SorterInterface
{
    public function sort(Builder $builder,array $allowedSortField): void;
}
