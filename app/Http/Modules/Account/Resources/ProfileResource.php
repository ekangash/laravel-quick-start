<?php

namespace App\Http\Modules\Account\Resources;

use App\Domain\Modules\Account\Models\Profile;
use App\Support\Resources\BaseJsonResource;
use Illuminate\Http\Request;

/**
 * Class ProfileResource
 *
 * @package App\Http\Modules\Account\Resources
 *
 * @mixin Profile
 */
class ProfileResource extends BaseJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $fullname = empty($this->firstname) && empty($this->lastname) ? 'Your Name' : "$this->firstname $this->lastname";

        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'fullname' => $fullname,
            'login' => $this->login,
            'status' => $this->status,
            'overview' => $this->overview,
            'city' => $this->city,
            'country' => $this->country,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'role' => $this->role,
            'cover' => $this->getFirstMediaFullUrl('cover'),
            'avatar' => $this->getFirstMediaFullUrl('avatar'),
            'confirmed_at' => !empty($this->firstname) && !empty($this->lastname),
            'created_at' =>  $this->created_at,
            'updated_at' =>  $this->updated_at,
        ];
    }
}
