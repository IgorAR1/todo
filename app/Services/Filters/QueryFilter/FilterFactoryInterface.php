<?php

namespace App\Services\Filters\QueryFilter;

interface FilterFactoryInterface
{
    public function crateFilter(string $type);
}
