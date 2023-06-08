<?php

namespace App\Http\Modules\Account\Resources;

use App\Domain\Modules\Account\Models\User;
use App\Support\Resources\BaseJsonResource;
use Illuminate\Http\Request;

/**
 * Class UsersResource
 *
 * @package App\Http\Modules\Account\Resources
 *
 * @mixin User
 */
class UsersResource extends BaseJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'profile' => ProfileResource::make($this->whenLoaded('profile')),
            'email_verified' => $this->hasVerifiedEmail(),
            'email_verified_at' => $this->email_verified_at,
        ];
    }
}
