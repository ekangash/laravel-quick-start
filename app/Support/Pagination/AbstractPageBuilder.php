<?php

namespace App\Support\Pagination;

use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;

abstract class AbstractPageBuilder
{
    protected bool $forbidToBypassPagination = false;

    protected ?int $maxLimit = null;

    public function __construct(protected QueryBuilder|EloquentQueryBuilder|SpatieQueryBuilder $query, protected Request $request)
    {
    }

    abstract public function build(): Page;

    public function forbidToBypassPagination(bool $value = true)
    {
        $this->forbidToBypassPagination = $value;

        return $this;
    }

    public function maxLimit(?int $maxLimit)
    {
        $this->maxLimit = $maxLimit;

        return $this;
    }

    protected function applyMaxLimit(int $limit): int
    {
        return $this->maxLimit !== null && $this->maxLimit > 0 ? min($limit, $this->maxLimit) : $limit;
    }

    protected function getDefaultLimit(): int
    {
        return config('pagination.default_limit');
    }
}
