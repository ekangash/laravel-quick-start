<?php

namespace App\Domain\Modules\Public\Actions\Topics;

use App\Domain\Modules\Public\Models\Topic;
use App\Domain\Modules\Public\Services\TopicValidation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class UpdateTopicAction
 *
 * @package App\Domain\Modules\Public\Actions\Topics
 */
class UpdateTopicAction
{

    /**
     * Обновляет запись.
     *
     * @param int $id Значение первичного ключа.
     * @param array $attributes Атрибуты записи.
     *
     * @return Topic
     *
     * @throws ModelNotFoundException
     */
    public function execute(int $id, array $attributes): Topic
    {
        return Topic::updateWithFillableAndUploadMedia($id, $attributes, function(Topic $model) {
            TopicValidation::checkAlreadySignExist($model->sign, function (Builder $query) use ($model) {
                $query->where('id', '!=', $model->id);

                return $query;
            });
        });
    }
}
