<?php


namespace App\Support\Resources;

use Illuminate\Http\Request;

class DataResource extends BaseJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [];
    }
}
