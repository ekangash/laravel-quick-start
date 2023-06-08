<?php

namespace App\Support\Pagination;

use App\Support\Enums\PaginationTypeEnum;
use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder as SpatieQueryBuilder;

class PageBuilderFactory
{
    public function fromQuery(QueryBuilder|EloquentQueryBuilder|SpatieQueryBuilder $query, ?Request $request = null): AbstractPageBuilder
    {
        $request = $request ?: resolve(Request::class);

        return $request->input('pagination.type', config('pagination.default_type')) === PaginationTypeEnum::CURSOR
            ? new CursorPageBuilder($query, $request)
            : new OffsetPageBuilder($query, $request);
    }
}
