<?php

namespace App\Support\Resources;

use App\Support\Pagination\Page;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class BaseJsonResource
 *
 * @package App\Support\Resources
 */
abstract class BaseJsonResource extends JsonResource
{
    /**
     * @param $resource
     * @param array $pagination
     *
     * @return AnonymousResourceCollection
     */
    public static function collectionWithPagination($resource, array $pagination): AnonymousResourceCollection
    {
        $collection = static::collection($resource);
        $currentAdditional = $collection->additional ?: [];
        $append = ['meta' => ['pagination' => $pagination]];

        return static::collection($resource)->additional(array_merge_recursive($currentAdditional, $append));
    }

    /**
     * @param Page $page
     *
     * @return AnonymousResourceCollection
     */
    public static function collectPage(Page $page): AnonymousResourceCollection
    {
        return static::collectionWithPagination($page->items, $page->pagination);
    }
}
