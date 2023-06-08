<?php

namespace App\Http\Modules\Account\Queries;

use App\Domain\Modules\Account\Models\Profile;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class ProfilesQuery
 *
 * @package App\Http\Modules\Account\Queries
 */
class ProfilesQuery extends QueryBuilder
{

    /**
     * ProfilesQuery constructor.
     *
     * @param Request $request
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $query = Profile::query();

        parent::__construct($query, new Request($request->all()));

        $this->allowedSorts(['id', 'created_at', 'updated_at']);

        $this->allowedFilters([
            AllowedFilter::exact('id'),
            AllowedFilter::scope('fullname'),
            AllowedFilter::scope('by_channel'),
            AllowedFilter::scope('not_in_ids'),
        ]);

        $this->allowedIncludes(['friends.related','channels']);

        $this->defaultSort('id');
    }
}
