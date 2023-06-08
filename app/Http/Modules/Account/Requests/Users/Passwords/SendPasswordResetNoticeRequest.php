<?php

namespace App\Http\Modules\Account\Requests\Users\Passwords;

use App\Support\Requests\BaseFormRequest;

/**
 * Class SendPasswordResetNoticeRequest
 *
 * @package App\Http\Modules\Account\Requests\Users\Passwords
 */
class SendPasswordResetNoticeRequest extends BaseFormRequest
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
        ];
    }

}
