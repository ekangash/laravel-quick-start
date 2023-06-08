<?php

namespace App\Domain\Modules\Account\Services\Profiles;

use App\Domain\Modules\Account\Models\Profile;
use Illuminate\Support\Facades\Auth;

/**
 * App\Domain\Modules\Account\Models\CurrentProfile
 */
class CurrentProfile
{

    /**
     * Возвращает модель текущего авторизированного профиля.
     *
     * @return Profile|null Текущий профиль
     */
    public static function current():?Profile
    {
        return Profile::find((int)request()->user()?->id);
    }

    /**
     * Возвращает идентификатор текущего авторизированного профиля.
     *
     * @return int Идентификатор текущего профиля
     */
    public static function currentId():int
    {
        return (int)self::current()?->id;
    }

    /**
     * Равны ли идентификатор пользователя с текущим авторизированным.
     *
     * @return int Идентификатор текущего профиля
     */
    public static function equalCurrentId(int $profileId):int
    {
        return self::currentId() === $profileId;
    }
}
