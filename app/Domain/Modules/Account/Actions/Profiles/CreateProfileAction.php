<?php

namespace App\Domain\Modules\Account\Actions\Profiles;

use App\Domain\Modules\Account\Models\Profile;

/**
 * Class CreateProfileAction
 *
 * @package App\Domain\Modules\Account\Actions\Profiles
 */
class CreateProfileAction
{
    /**
     * Формирует новую запись.
     *
     * @param array $attributes Атрибуты записи.
     *
     * @return Profile
     */
    public function execute(array $attributes): Profile
    {
        return Profile::createWithFillableAndUploadMedia($attributes);
    }
}
