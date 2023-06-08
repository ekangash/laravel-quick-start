<?php

namespace App\Support\Enums;

class PaginationTypeEnum
{
    /**
     * Possible values of this enum
     */
    const CURSOR = 'cursor';
    const OFFSET = 'offset';

    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public static function getAllowableEnumValues(): array
    {
        return [
            self::CURSOR,
            self::OFFSET,
        ];
    }
}


