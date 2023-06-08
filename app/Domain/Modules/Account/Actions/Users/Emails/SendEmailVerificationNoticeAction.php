<?php

namespace App\Domain\Modules\Account\Actions\Users\Emails;

use App\Domain\Modules\Account\Models\User;
use App\Http\Modules\Account\Resources\UsersResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class CheckResetPassword
 *
 * @package App\Domain\Modules\Account\Actions\Users\Passwords
 */
class SendEmailVerificationNoticeAction
{
    /**
     * Верифицирует электронную почту аккаунта.
     *
     * @param User $user
     *
     * @return JsonResponse|UsersResource
     */
    public function execute(User $user): JsonResponse|UsersResource
    {
        if ($user->hasVerifiedEmail()) {
            return new UsersResource($user);
        }

        $user->sendEmailVerificationNotification();

        return new JsonResponse(['data' => []], Response::HTTP_CREATED);
    }
}
