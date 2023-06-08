<?php

namespace App\Domain\Modules\Account\Actions\Users\Passwords;

use App\Domain\Modules\Account\Models\User;
use App\Http\Modules\Account\Requests\Users\Passwords\ResetPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * Class ResetPasswordAction
 *
 * @package App\Domain\Modules\Account\Actions\Users\Passwords
 */
class ResetPasswordAction
{

    /**
     * @param ResetPasswordRequest $request
     *
     * @return JsonResponse
     */
    public function execute(ResetPasswordRequest $request): JsonResponse
    {
        $response = $this->broker()->reset($request->only('email'), function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        return $response == Password::PASSWORD_RESET
            ? new JsonResponse(['message' => "Пароль успешно изменен!"], 200)
            : new JsonResponse(['message' => "Попытка изменения пароля потерпела крах!"], 418);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    public function broker():PasswordBroker
    {
        return Password::broker();
    }

    /**
     * Reset the given user's password.
     *
     * @param  User  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword(User $user, string $password)
    {
        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return StatefulGuard
     */
    protected function guard(): StatefulGuard
    {
        return Auth::guard();
    }
}
