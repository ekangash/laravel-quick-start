<?php

namespace App\Http\Modules\Account\Requests\Users;

use App\Support\Requests\BaseFormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * Class LoginUserRequest
 *
 * @package App\Http\Modules\Account\Requests\Users
 */
class LoginUserRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string'],
            'password' => ['required', 'string', Password::min(6)],
            'token_name' => ['required', 'string'],
        ];
    }

}
