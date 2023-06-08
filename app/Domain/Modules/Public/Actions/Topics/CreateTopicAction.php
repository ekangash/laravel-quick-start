<?php

namespace App\Domain\Modules\Public\Actions\Topics;

use App\Domain\Modules\Public\Models\Topic;
use App\Domain\Modules\Public\Services\TopicValidation;
use Illuminate\Support\Arr;

/**
 * Class CreateTopicAction
 *
 * @package App\Domain\Modules\Public\Actions\Topics
 */
class CreateTopicAction
{

    /**
     * Формирует новую запись.

     * @param array $attributes Атрибуты записи.
     *
     * @return Topic
     */
    public function execute(array $attributes): Topic
    {
        TopicValidation::checkAlreadySignExist(Arr::get($attributes, 'sign', ''));

        return Topic::createWithFillableAndUploadMedia($attributes);
    }
}
