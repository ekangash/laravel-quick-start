<?php

namespace App\Domain\Modules\Account\Actions\Profiles;

use App\Domain\Modules\Account\Models\Profile;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class UpdateProfileAction
 *
 * @package App\Domain\Modules\Account\Actions\Profiles
 */
class UpdateProfileAction
{
    /**
     * Обновляет запись.
     *
     * @param int $id Значение первичного ключа.
     * @param array $attributes Атрибуты записи.
     *
     * @return Profile Обновлённый профиль.
     *
     * @throws ModelNotFoundException
     */
    public function execute(int $id, array $attributes): Profile
    {
        return Profile::updateWithFillableAndUploadMedia($id, $attributes);
    }
}
