<?php
namespace App\Domain\Modules\Account\Enums;

use App\Support\Enums\Contracts\EnumInterface;

/**
 * Класс PostsState для работы с псевдонимами состояний поста.
 */
class ProfileRoles implements EnumInterface
{
    const READER = 1;
    const EDITOR = 2;
    const WRITER = 3;

    /**
     * @var array Псевдонимы.
     */
    protected static array $aliases = [
        self::READER => 'Читатель',
        self::EDITOR => 'Редактор',
        self::WRITER => 'Писатель'
    ];

    /**
     * @return string Псевдоним.
     */
    public static function getElias($type): string
    {
        return self::$aliases[$type];
    }

    public static function getAllowableEnumValues(): array
    {
        return self::$aliases;
    }
}
