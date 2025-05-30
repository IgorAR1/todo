<?php

namespace App\Services\Filters\QueryFilter;


use App\Services\Filters\FilterInterface;
use App\Services\Filters\QueryRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class QueryFilters
{
    private array $filters = [];

    public function __construct(
        readonly FilterFactory $factory,
        protected readonly QueryRequest $request
    )
    {
    }

    /**
     * @throws InvalidFilter
     */

    public function apply(Builder $builder): void
    {
        $requestedFilters = $this->request->getFilterQueryProperties();

        if (empty($this->filters) || $requestedFilters->isEmpty()) {
            return;
        }

        $this->ensureFieldsIsFilterable($requestedFilters);

        $requestedFilters->each(function ($property) use ($builder) {
            $values = $this->resolveQueryValues($property);
//            $values = $this->request->getFilterValues($property);

            $filter = $this->filterUsing($property);

            if ($this->isRelations($builder, $property)) {
                $this->withRelationship($filter, $builder, $property, $values);

                return;
            }
            $filter->filter($builder, $property, $values);
        });

    }

    public function withFilters(array $allowedFilters): static
    {
        $this->filters = $allowedFilters;

        return $this;
    }

    private function filterUsing(string $name): FilterInterface//Та можно и callable сюда передавать
    {
        return $this->resolveFilter($name);
    }

    private function resolveFilter(string $name): FilterInterface
    {
        $filterType = $this->filters[$name];

        if ($filterType instanceof FilterInterface) {
            return $filterType;
        }

        if (is_string($filterType)) {
            if (class_exists($filterType)) {
                return new $filterType();
            }

            return $this->factory->crateFilter($name);
        }

        throw new InvalidFilter($filterType. ' could not be resolved.');
    }

    private function resolveQueryValues(string $property): array
    {
        return explode(',', $this->request->getFilterValues($property));
    }

    protected function isRelations(Builder $builder, string $property): bool
    {
        if (!Str::contains($property, '.')) {
            return false;
        }

        $relationship = explode('.', $property)[0];

        return method_exists($builder->getModel(), $relationship);
    }

    protected function withRelationship(FilterInterface $filter, Builder $builder, string $property, array $values): Builder
    {
        $parts = explode('.', $property);

        $relation = implode('.', Arr::except($parts, count($parts) - 1));
        $property = Arr::last($parts);

        return $builder->whereHas($relation, function (Builder $builder) use ($values, $property, $filter) {
            $filter->filter($builder, $property, $values);
        });
    }

    /**
     * @throws InvalidFilter
     */
    private function ensureFieldsIsFilterable(Collection $requestedFilters): void
    {
        $allowedFilters = array_keys($this->filters);

        if ($requestedFilters->diff($allowedFilters)->isNotEmpty()) {
            throw new InvalidFilter('Invalid filter name');
        }
    }
}
