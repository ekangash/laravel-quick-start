<?php

namespace App\Domain\Modules\Public\Actions\Topics;

use App\Domain\Modules\Public\Models\Topic;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class DeleteTopicAction
 *
 * @package App\Domain\Modules\Public\Actions\Topics
 */
class DeleteTopicAction
{
    /**
     * Удаляет запись.
     *
     * @param int $id Значение первичного ключа.
     *
     * @return bool|null
     *
     * @throws ModelNotFoundException
     */
    public function execute(int $id): ?bool
    {
        return Topic::deleteAndClearMedia($id);
    }
}
