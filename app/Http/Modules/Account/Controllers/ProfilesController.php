<?php

namespace App\Http\Modules\Account\Controllers;

use App\Domain\Modules\Account\Actions\Profiles\UpdateProfileAction;
use App\Http\Modules\Account\Queries\ProfilesQuery;
use App\Http\Modules\Account\Requests\Profiles\UpdateProfileRequest;
use App\Http\Modules\Account\Resources\ProfileResource;
use App\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ProfilesController
 *
 * @package App\Http\Modules\Account\Controllers
 */
class ProfilesController
{
    /**
     * @param int $id Значение первичного ключа.
     * @param ProfilesQuery $query
     *
     * @return ProfileResource
     */
    public function get(int $id, ProfilesQuery $query): ProfileResource
    {
        return new ProfileResource($query->findOrFail($id));
    }

    /**
     * Обновляет запись.
     *
     * @param int $id Значение первичного ключа.
     * @param UpdateProfileRequest $request
     * @param UpdateProfileAction $action
     *
     * @return ProfileResource
     */
    public function update(int $id, UpdateProfileRequest $request, UpdateProfileAction $action): ProfileResource
    {
        return new ProfileResource($action->execute($id, $request->validated()));
    }

    /**
     * Поиск пользователей, удовлетворяющие фильтру.
     *
     * @param PageBuilderFactory $pageBuilderFactory
     * @param ProfilesQuery $query
     *
     * @return AnonymousResourceCollection
     */
    public function search(PageBuilderFactory $pageBuilderFactory, ProfilesQuery $query): AnonymousResourceCollection
    {
        return ProfileResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }

    /**
     * Поиск пользователя, удовлетворяющего фильтру
     *
     * @param ProfilesQuery $query
     *
     * @return ProfileResource
     */
    public function searchOne(ProfilesQuery $query): ProfileResource
    {
        return new ProfileResource($query->firstOrFail());
    }
}
