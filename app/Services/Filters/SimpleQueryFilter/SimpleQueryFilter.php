<?php

namespace App\Services\Filters\SimpleQueryFilter;

use App\Services\Filters\FilterInterface;
use App\Services\Filters\QueryRequest;
use Illuminate\Database\Eloquent\Builder;

abstract class SimpleQueryFilter implements FilterInterface
{
    public function __construct(readonly QueryRequest $request)
    {
    }

    public function apply(Builder $builder): Builder
    {
        $filters = $this->request->input('filter');

        if (empty($filters)) {
            return $builder;
        }

        foreach ($filters as $property => $values) {
            $values = $this->formatQueryValues($values);

            $this->filter($builder, $property, $values);
        }

        return $builder;
    }

    public function filter(Builder $builder, string $property, array $values): void
    {
        if (method_exists($this, $property)) {
            $this->{$property}($builder, $values);
        }
    }

    private function formatQueryValues(string $values): array
    {
        return explode(',', $values);
    }
}
