<?php

namespace App\Http\Modules\Account\Resources;

use App\Support\Resources\BaseJsonResource;
use Illuminate\Http\Request;
use Laravel\Sanctum\NewAccessToken;

/**
 * Class TokenResource
 *
 * @package App\Http\Modules\Account\Resources\
 *
 * @mixin NewAccessToken
 */
class TokenResource extends BaseJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return ['token' => $this->plainTextToken];
    }
}
