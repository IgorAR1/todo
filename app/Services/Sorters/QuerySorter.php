<?php

namespace App\Services\Sorters;

use App\Services\Filters\QueryRequest;
use Illuminate\Database\Eloquent\Builder;

class QuerySorter implements SorterInterface
{
    public function __construct(public readonly QueryRequest $request)
    {
    }

    public function sort(Builder $builder, array $allowedSortField): void
    {
        $direction = $this->request->getSortDirection();

        $this->request->getSortProperties()->each(function ($property) use ($builder, $direction, $allowedSortField) {
            if (in_array($property, $allowedSortField)) {
                $this->sortBy($builder, $property, $direction);
            }
        });
    }

    private function sortBy(Builder $builder, string $property, ?string $direction = 'desc'): void
    {
        $builder->orderBy($property, $direction);
    }
}
