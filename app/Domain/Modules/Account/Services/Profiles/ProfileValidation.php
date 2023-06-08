<?php

namespace App\Domain\Modules\Account\Services\Profiles;

use App\Domain\Modules\Account\Models\Profile;
use App\Exceptions\ModelNotFoundException;
use App\Exceptions\Http\UnprocessableEntityHttpException;

/**
 * Class ProfileValidation
 *
 * @package App\Domain\Modules\Account\Services\Profiles
 */
class ProfileValidation
{

    /**
     * Проверяет принадлежит ли данный канал текущему пользователю
     *
     * @param int $profileId Идентификатор пользователя
     *
     * @return void
     */
    public static function checkIsEqualToCurrentProfile(int $profileId):void
    {
        if (!CurrentProfile::equalCurrentId($profileId)) {
            throw new UnprocessableEntityHttpException('Недостаточно прав: профиль не соответствует авторизированному!');
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
            throw new ModelNotFoundException("Ошибка: профиль {$profileId} не определен.");
        }
    }
}
