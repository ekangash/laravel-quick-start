<?php

namespace App\Http\Modules\Account\Requests\Users\Passwords;

use App\Support\Requests\BaseFormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * Class ResetPasswordRequest
 *
 * @package App\Http\Modules\Account\Requests\Users\Passwords
 */
class ResetPasswordRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => ['required|confirmed|string', Password::min(8)],
        ];
    }

}
