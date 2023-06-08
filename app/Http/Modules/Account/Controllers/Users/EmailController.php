<?php

namespace App\Http\Modules\Account\Controllers\Users;

use App\Domain\Modules\Account\Actions\Users\Emails\SendEmailVerificationNoticeAction;
use App\Domain\Modules\Account\Actions\Users\Emails\VerifyEmailAction;
use App\Http\Modules\Account\Resources\UsersResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class EmailController
 *
 * @package App\Http\Modules\Account\Controllers\Users
 */
class EmailController
{
    /**
     * Верифицирует электронную почту аккаунта.
     *
     * @param Request $request
     * @param SendEmailVerificationNoticeAction $action
     *
     * @return JsonResponse|UsersResource
     */
    public function sendVerificationNotice(Request $request, SendEmailVerificationNoticeAction $action): JsonResponse|UsersResource
    {
        return $action->execute($request->user());
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param int $id Идентификатор пользователя.
     * @param Request $request Объект запроса.
     * @param VerifyEmailAction $action
     *
     * @return JsonResponse
     */
    public function verify(int $id, Request $request, VerifyEmailAction $action): JsonResponse
    {
        return $action->execute($id, $request);
    }
}
