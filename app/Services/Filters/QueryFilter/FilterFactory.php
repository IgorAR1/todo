<?php

namespace App\Services\Filters\QueryFilter;

use App\Services\Filters\FilterInterface;

class FilterFactory implements FilterFactoryInterface
{
    public function crateFilter(string $type): FilterInterface
    {
        return match ($type) {
            'exact' => new QueryFilterExact(),
            'partial' => new QueryFilterPartial(),
            default => throw new InvalidFilter("Filter type {$type} not supported."),
        };
    }
}
