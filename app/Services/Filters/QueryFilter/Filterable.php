<?php

namespace App\Services\Filters\QueryFilter;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public array $allowedFilters = [];
    /**
     * @throws InvalidFilter
     */
    public function scopeFilter(Builder $builder, array $allowedFilters = []):Builder
    {
        if (empty($allowedFilters)) {
            return $builder;
        }

        $queryFilter = $this->filterUsing();
//
//        foreach ($allowedFilters as $property => $filter){
//            if (! $filter instanceof FilterInterface) {
//                if (! is_string($filter)) {
//                    throw new InvalidFilter('Filter name must be a string');
//                }
//                $this->allowedFilters[$filter] = $queryFilter->factory->createExactFilter();
//            }
//            else $this->allowedFilters[$property] = $filter;
//        }

        $queryFilter->withFilters($allowedFilters)->apply($builder);

        return $builder;
    }

    private function filterUsing()
    {
       return app(QueryFilters::class);
    }
}
