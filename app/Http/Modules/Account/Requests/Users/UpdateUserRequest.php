<?php

namespace App\Http\Modules\Account\Requests\Users;

use App\Support\Requests\BaseFormRequest;

/**
 * Class UpdateUserRequest
 *
 * @package App\Http\Modules\Account\Requests\Users
 */
class UpdateUserRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ['email' => ['required', 'email']];
    }

}
