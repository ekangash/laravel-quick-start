<?php

namespace App\Http\Modules\Account\Requests\Profiles;

use App\Support\Requests\BaseFormRequest;

/**
 * Class UpdateProfileRequest
 *
 * @package App\Http\Modules\Account\Requests\Profiles
 */
class UpdateProfileRequest extends BaseFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules():array
    {
        return [
            'role' => ['sometimes', 'required', 'string'],
            'firstname' => ['sometimes', 'required', 'string'],
            'lastname' => ['sometimes', 'required','string'],
            'status' => ['sometimes', 'string'],
            'overview' => ['sometimes', 'array'],
            'login' => ['sometimes', 'string'],
            'city' => ['sometimes', 'string'],
            'country' => ['sometimes', 'string'],
            'gender' => ['sometimes', 'string'],
            'contact' => ['sometimes', 'string'],
            'birthday' => ['sometimes', 'string'],
            'experience' => ['sometimes', 'string'],
            'biography' => ['sometimes', 'string'],
            'cover' => ['sometimes', 'nullable'],
            'avatar' => ['sometimes', 'nullable'],
        ];
    }
}
