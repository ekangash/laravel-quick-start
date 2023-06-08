<?php

namespace App\Http\Modules\Account\Requests\Users\Passwords;

use App\Support\Requests\BaseFormRequest;

/**
 * Class CheckPasswordResetTokenRequest
 *
 * @package App\Http\Modules\Account\Requests\Users\Passwords
 */
class CheckPasswordResetTokenRequest extends BaseFormRequest
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
            'email' => 'required|string|email',
        ];
    }

}
