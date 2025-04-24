<?php

namespace App\Services\Sorters;

use Illuminate\Database\Eloquent\Builder;

trait Sortable
{
    public function scopeSort(Builder $builder,array $allowedSortField):Builder
    {
        $sorter = $this->sortUsing();
        $sorter->sort($builder, $allowedSortField);

        return $builder;
    }

    public function sortUsing(): SorterInterface
    {
        return app(SorterInterface::class);
    }
}
