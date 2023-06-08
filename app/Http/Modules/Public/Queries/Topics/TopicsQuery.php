<?php

namespace App\Http\Modules\Public\Queries\Topics;

use App\Domain\Modules\Public\Models\Topic;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class TopicsQuery
 *
 * @package App\Http\Modules\Public\Queries\Topics
 */
class TopicsQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Topic::query();

        parent::__construct($query, new Request($request->all()));

        $this->allowedSorts(['id', 'title', 'created_at', 'updated_at']);

        $this->allowedFilters([
            AllowedFilter::exact('id'),
            AllowedFilter::exact('title'),
        ]);

        $this->defaultSort('id');
    }
}
