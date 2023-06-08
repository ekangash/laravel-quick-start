<?php

namespace App\Support\Media;

use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

/**
 * Class UrlGenerator
 *
 * @package App\Support\Media
 */
class UrlGenerator extends DefaultUrlGenerator
{
    public function getUrl(): string
    {
        return '/' . config('media-library.disk_name') . '/' . $this->getPathRelativeToRoot();
    }
}
