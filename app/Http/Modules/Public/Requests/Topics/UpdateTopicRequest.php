<?php

namespace App\Http\Modules\Public\Requests\Topics;

use App\Support\Requests\BaseFormRequest;

/**
 * Class UpdateTopicRequest
 *
 * @package App\Http\Modules\Public\Requests\Topics
 */
class UpdateTopicRequest extends BaseFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['nullable', 'array'],
            'sign' => ['nullable', 'string'],
            'parent_id' => ['sometimes', 'integer'],
            'queue' => ['sometimes', 'integer'],
            'cover' => ['sometimes', 'nullable'],
        ];
    }

}
