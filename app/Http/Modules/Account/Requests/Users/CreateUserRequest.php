<?php

namespace App\Http\Modules\Account\Requests\Users;

use App\Support\Requests\BaseFormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * Class CreateUserRequest
 *
 * @package App\Http\Modules\Account\Requests\Users
 */
class CreateUserRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', Password::min(8)],
        ];
    }
}
