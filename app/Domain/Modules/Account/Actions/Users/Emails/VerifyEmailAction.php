<?php

namespace App\Domain\Modules\Account\Actions\Users\Emails;

use App\Domain\Modules\Account\Models\User;
use App\Exceptions\Http\ForbiddenException;
use App\Exceptions\Http\IAmTeapotException;
use App\Http\Modules\Account\Resources\UsersResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class CheckResetPassword
 *
 * @package App\Domain\Modules\Account\Actions\Users\Passwords
 */
class VerifyEmailAction
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param int $id Идентификатор пользователя.
     * @param Request $request Объект запроса.
     *
     * @return JsonResponse
     */
    public function execute(int $id, Request $request): JsonResponse
    {
        if (!$request->hasValidSignature(false)) {
            throw new ForbiddenException('Активное время на активацию почтового адреса вышло.');
        }

        /** @var User $user */
        $user = User::findOrFail($id);

        if ($user->hasVerifiedEmail()) {
            throw new IAmTeapotException("Почтовый адрес {$user->email} уже подтверждён!");
        }

        $user->markEmailAsVerified();

        return new JsonResponse(['message' => "Почтовый адрес {$user->email} успешно подтверждён!"], Response::HTTP_OK);
    }
}
