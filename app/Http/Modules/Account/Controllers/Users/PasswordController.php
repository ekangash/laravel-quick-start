<?php

namespace App\Http\Modules\Account\Controllers\Users;

use App\Domain\Modules\Account\Actions\Users\Passwords\CheckPasswordResetTokenAction;
use App\Domain\Modules\Account\Actions\Users\Passwords\ResetPasswordAction;
use App\Domain\Modules\Account\Actions\Users\Passwords\SendPasswordResetNoticeAction;
use App\Http\Modules\Account\Requests\Users\Passwords\CheckPasswordResetTokenRequest;
use App\Http\Modules\Account\Requests\Users\Passwords\ResetPasswordRequest;
use App\Http\Modules\Account\Requests\Users\Passwords\SendPasswordResetNoticeRequest;
use App\Support\Resources\EmptyResource;
use Illuminate\Http\JsonResponse;

/**
 * Class PasswordController
 *
 * @package App\Http\Modules\Account\Controllers\Users
 */
class PasswordController
{
    /**
     * Отправляет ссылку/уведомление на сброс пароля пользователю.
     *
     * @param SendPasswordResetNoticeAction $action
     * @param SendPasswordResetNoticeRequest $request
     *
     * @return JsonResponse
     */
    public function sendResetNotice(SendPasswordResetNoticeAction $action, SendPasswordResetNoticeRequest $request): JsonResponse
    {
        return $action->execute($request);
    }

    /**
     * Проверяет разрешенный ли токен сброса
     *
     * @param CheckPasswordResetTokenAction $action
     * @param CheckPasswordResetTokenRequest $request
     *
     * @return EmptyResource
     */
    public function checkResetToken(CheckPasswordResetTokenAction $action, CheckPasswordResetTokenRequest $request): EmptyResource
    {
        $action->execute($request->validated());

        return new EmptyResource();
    }

    /**
     * Reset the given user's password.
     *
     * @param ResetPasswordAction $action
     * @param ResetPasswordRequest $request
     *
     * @return JsonResponse
     */
    public function reset(ResetPasswordAction $action, ResetPasswordRequest $request): JsonResponse
    {
        return $action->execute($request);
    }
}
