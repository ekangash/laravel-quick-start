<?php

namespace App\Domain\Modules\Account\Actions\Users;

use App\Domain\Modules\Account\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

/**
 * Class UpdateUserAction
 *
 * @package App\Domain\Modules\Account\Actions\Users
 */
class UpdateUserAction
{

    /**
     * @param int id
     * @param array $attributes Атрибуты записи.
     *
     * @return User
     *
     * @throws ModelNotFoundException
     */
    public function execute(int $id, array $attributes): User
    {
        /** @var User $user */
        $user = User::findOrFail($id);
        $user->update(Arr::only($attributes, User::FILLABLE));

        return $user;
    }
}
