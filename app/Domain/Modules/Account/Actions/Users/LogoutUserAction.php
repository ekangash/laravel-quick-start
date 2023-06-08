<?php

namespace App\Domain\Modules\Account\Actions\Users;

use App\Domain\Modules\Account\Models\User;
use Laravel\Sanctum\NewAccessToken;

/**
 * Class LogoutUserAction
 *
 * @package App\Domain\Modules\Account\Actions\Users
 */
class LogoutUserAction
{
    /**
     * @param User $user
     *
     * @return bool|null
     */
    public function execute(User $user): ?bool
    {
        /** @var NewAccessToken $token */
        $token = $user->currentAccessToken();

        return $token->delete();
    }
}
