<?php

namespace App\Domain\Modules\Account\Actions\Users\Passwords;

use App\Domain\Modules\Account\Models\User;
use App\Exceptions\Http\ForbiddenException;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Password;

/**
 * Class CheckResetPassword
 *
 * @package App\Domain\Modules\Account\Actions\Users\Passwords
 */
class CheckPasswordResetTokenAction
{
    /**
     * @param array $attributes Атрибуты записи.
     *
     * @return void
     *
     * @throws ForbiddenException
     */
    public function execute(array $attributes): void
    {
        $email = Arr::get($attributes, 'email', '');
        $user = User::findByEmail($email);

        if (is_null($user)) {
            throw new ForbiddenException("Учетная запись '$email' не определена.");
        }

        if (!$this->broker()->tokenExists($user, Arr::get($attributes, 'token', ''))) {
            throw new ForbiddenException('Нет доступа к операции восстановлении пароля, подпись недействительна.');
        }
    }


    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    public function broker(): PasswordBroker
    {
        return Password::broker();
    }
}
