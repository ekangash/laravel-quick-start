<?php

namespace App\Domain\Modules\Public\Services;

use App\Domain\Modules\Account\Models\Profile;
use App\Domain\Modules\Public\Models\Topic;
use App\Exceptions\ModelNotFoundException;
use App\Exceptions\UniqueConstraintException;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ProfileValidation
 *
 * @package App\Domain\Modules\Account\Services\Profiles
 */
class TopicValidation
{

    /**
     * Проверяет принадлежит ли данный канал текущему пользователю
     *
     * @param string $sign Идентификатор пользователя
     * @param Closure|null $conditionFn Условия фильтрации.
     *
     * @return void
     */
    public static function checkAlreadySignExist(string $sign, Closure $conditionFn = null): void
    {
        $topicIsDefined = Topic::defined(function(Builder $query) use ($sign, $conditionFn) {
            $query->where(['sign' => $sign]);

            if ($conditionFn instanceof Closure) {
                $conditionFn($query);
            }

            return $query;
        });

        if ($topicIsDefined) {
            throw new UniqueConstraintException("сигнатура темы '$sign' уже используется!");
        }
    }

    /**
     * Проверяет определен ли текущий пользователь.
     *
     * @param int $profileId Идентификатор профиля
     *
     * @return void
     */
    public static function checkIsNotDefined(int $profileId):void
    {
        if (!Profile::defined($profileId)) {
            throw new ModelNotFoundException("Ошибка: тема {$profileId} не определен.");
        }
    }
}
