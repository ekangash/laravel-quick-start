<?php

namespace App\Http\Modules\Public\Resources\Topics;

use App\Domain\Modules\Public\Models\Topic;
use App\Support\Resources\BaseJsonResource;
use Illuminate\Http\Request;

/**
 * Class TopicResource
 *
 * @package App\Http\Modules\Public\Resources\Topics
 *
 * @mixin Topic
 */
class TopicResource extends BaseJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'sign' => $this->sign,
            'parent_id' => $this->parent_id,
            'cover' => $this->cover,
            'created_at' =>  $this->created_at,
            'updated_at' =>  $this->updated_at,
        ];
    }
}
