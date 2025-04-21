<?php

namespace App\Services\Filters\QueryFilter;

use App\Contracts\Filter;
use App\Enums\SqlOperators;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class QueryFilterRange implements FilterInterface
{
//    private ?int $min = null;
//    private ?int $max = null;

    private string $operator;
    public function __construct(SqlOperators $operator)
    {
        $this->operator = $operator->value;
    }


    public function filter(Builder $builder, string $property, array $values): void
    {
        $property = $this->resolveProperty($property);

        $builder->whereIn($property, $this->operator, $values);
    }

    private function resolveProperty($property): string
    {
        if (Str::contains($property,'_min')) {
            return explode('_min', $property)[0];
        }
        else{
            return explode('_max', $property)[0];
        }
    }

//    private function getRange($property): array//Какая то ебатория
//    {
//        dd($this->request->getFilterQueryProperties()
//            ->filter(function ($value) use ($property) {
//                return (Str::contains($value,$property.'_min') || Str::contains($property,$property.'_max'));
//            })
//        );
//
//    }

}
