<?php

namespace App\Domain\Modules\Account\Services\Users;

use App\Domain\Modules\Account\Models\User;
use App\Exceptions\UniqueConstraintException;

class UserValidation
{

    /**
     * Проверяет емайл на занятость.
     *
     * @param string $email Идентификатор пользователя
     *
     * @return void
     */
    public static function checkEmailIsBusy(string $email):void
    {
        if (!is_null(User::findByEmail($email))) {
            throw new UniqueConstraintException("учетная запись с таким почтовым адресом '$email' уже зарегистрирована!");
        }
    }
}
