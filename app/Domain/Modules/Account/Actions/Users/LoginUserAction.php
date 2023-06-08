<?php

namespace App\Domain\Modules\Account\Actions\Users;

use App\Domain\Modules\Account\Models\User;
use App\Exceptions\Http\UnauthorizedHttpException;
use Laravel\Sanctum\NewAccessToken;

/**
 * Class LoginUserAction
 *
 * @package App\Domain\Modules\Account\Actions\Users
 */
class LoginUserAction
{
    /**
     * @param array $attributes Атрибуты записи.
     *
     * @return NewAccessToken
     *
     * @throws UnauthorizedHttpException
     */
    public function execute(array $attributes): NewAccessToken
    {
        $user = User::findByEmail($attributes['email']);

        if (is_null($user) || !$user->checkPassword($attributes['password'])) {
            throw new UnauthorizedHttpException('','Введен неверный логин или пароль');
        }

        return $user->createToken($attributes['token_name']);
    }
}
