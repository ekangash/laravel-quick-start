<?php

namespace App\Domain\Modules\Account\Actions\Users;

use App\Domain\Modules\Account\Actions\Profiles\CreateProfileAction;
use App\Domain\Modules\Account\Models\User;
use App\Domain\Modules\Account\Services\Users\UserValidation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Class CreateUserAction
 *
 * @package App\Domain\Modules\Account\Actions\Users
 */
class CreateUserAction
{
    /**
     * Формирует новую запись.
     *
     * @param array $attributes Атрибуты записи.
     *
     * @return User
     */
    public function execute(array $attributes): User
    {
        UserValidation::checkEmailIsBusy(Arr::get($attributes, 'email', ''));

        $user = DB::transaction(function() use ($attributes) {
            /** @var User $user */
            $user = User::create(Arr::only($attributes, User::FILLABLE));
            (new CreateProfileAction())->execute(['user_id' => $user->id]);

            return $user;
        });

        $user->load('profile');
        $user->sendEmailVerificationNotification();

        return $user;
    }
}
