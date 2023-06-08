<?php

namespace App\Domain\Modules\Account\Actions\Users\Passwords;

use App\Http\Modules\Account\Requests\Users\Passwords\SendPasswordResetNoticeRequest;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;

/**
 * Class SendPasswordResetNoticeAction
 *
 * @package App\Domain\Modules\Account\Actions\Users\Passwords
 */
class SendPasswordResetNoticeAction
{
    /**
     * @param SendPasswordResetNoticeRequest $request
     *
     * @return JsonResponse
     */
    public function execute(SendPasswordResetNoticeRequest $request): JsonResponse
    {
        $email = $request->input('email');

        $resetLinkStatus = $this->broker()->sendResetLink(['email' => $email]);

        if ($resetLinkStatus === Password::INVALID_USER) {
            return new JsonResponse(['message' => "Учетная запись '$email' не идентифицирована в системе!"], Response::HTTP_I_AM_A_TEAPOT);
        }

        if ($resetLinkStatus === Password::RESET_LINK_SENT) {
            return new JsonResponse(['message' => "Запрос на восстановление пароля учётной записи $email успешно выполнен!"], Response::HTTP_CREATED);
        }

        return new JsonResponse(['message' => "Не удалось отправить уведомление сброса пароля на почтовый адрес '$email'"], Response::HTTP_FORBIDDEN);
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
