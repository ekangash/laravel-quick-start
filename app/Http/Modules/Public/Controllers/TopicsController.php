<?php

namespace App\Http\Modules\Public\Controllers;

use App\Domain\Modules\Public\Actions\Topics\CreateTopicAction;
use App\Domain\Modules\Public\Actions\Topics\UpdateTopicAction;
use App\Domain\Modules\Public\Actions\Topics\DeleteTopicAction;
use App\Http\Modules\Public\Queries\Topics\TopicsQuery;
use App\Http\Modules\Public\Requests\Topics\CreateTopicRequest;
use App\Http\Modules\Public\Requests\Topics\UpdateTopicRequest;
use App\Http\Modules\Public\Resources\Topics\TopicResource;
use App\Support\Pagination\PageBuilderFactory;
use App\Support\Resources\EmptyResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

/**
 * Class TopicsController
 *
 * @package App\Http\Modules\Public\Controllers
 */
class TopicsController
{

    /**
     * Возвращает категорию.
     *
     * @param int $id Значение первичного ключа.
     * @param TopicsQuery $query Построитель запросов
     *
     * @return TopicResource Ресурс категории
     */
    public function get(int $id, TopicsQuery $query): TopicResource
    {
        return new TopicResource($query->findOrFail($id));
    }

    /**
     * Формирует новую запись.
     *
     * @param CreateTopicRequest $request
     * @param CreateTopicAction $action
     *
     * @return TopicResource
     */
    public function create(CreateTopicRequest $request, CreateTopicAction $action): TopicResource
    {
        return new TopicResource($action->execute($request->validated()));
    }

    /**
     * Обновляет запись.
     *
     * @param int $id Значение первичного ключа.
     * @param UpdateTopicRequest $request
     * @param UpdateTopicAction $action
     *
     * @return TopicResource
     */
    public function update(int $id, UpdateTopicRequest $request, UpdateTopicAction $action):TopicResource
    {
        return new TopicResource($action->execute($id, $request->validated()));
    }

    /**
     * Удаляет запись.
     *
     * @param int $id Значение первичного ключа.
     * @param DeleteTopicAction $action
     *
     * @return EmptyResource
     */
    public function delete(int $id, DeleteTopicAction $action):EmptyResource
    {
        $action->execute($id);

        return new EmptyResource();
    }

    /**
     * @param PageBuilderFactory $pageBuilderFactory
     * @param TopicsQuery $query
     *
     * @return AnonymousResourceCollection
     */
    public function search(PageBuilderFactory $pageBuilderFactory, TopicsQuery $query):AnonymousResourceCollection
    {
        return TopicResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }

    /**
     * @param TopicsQuery $query
     *
     * @return TopicResource
     */
    public function searchOne(TopicsQuery $query):TopicResource
    {
        return new TopicResource($query->firstOrFail());
    }
}
