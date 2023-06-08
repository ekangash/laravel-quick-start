<?php

namespace App\Http\Modules\Account\Queries;

use App\Domain\Modules\Account\Models\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class UsersQuery
 *
 * @package App\Http\Modules\Account\Queries
 */
class UsersQuery extends QueryBuilder
{

    /**
     * UsersQuery constructor.
     *
     * @param Request $request
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $query = User::query();

        parent::__construct($query, new Request($request->all()));

        $this->allowedSorts(['id', 'created_at', 'updated_at']);

        $this->allowedFilters([
            AllowedFilter::exact('id'),
        ]);

        $this->defaultSort('id');
    }
}
