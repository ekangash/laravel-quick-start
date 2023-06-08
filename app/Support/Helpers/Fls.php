<?php


namespace App\Support\Helpers;

use Illuminate\Http\UploadedFile;

/**
 * Class Fls at FileSystem
 *
 * @package App\Support\Helpers
 */
class Fls
{
    /**
     * Проверяет, имеет ли структура экземпляр файла загрузки.
     *
     * @param mixed $value Проверяемое значение
     *
     * @return bool Имеет ли структура экземпляр файла загрузки.
     */
    public static function hasUploadedFile(mixed $value): bool
    {
        $result = false;

        if (is_array($value)) {
            foreach ($value as $item) {
                if ($item instanceof UploadedFile) {
                    $result = true;
                    break;
                } else if (is_array($item)) {
                    $result = static::hasUploadedFile($item);
                }
            }
        } else {
            $result = $value instanceof UploadedFile;
        }

        return $result;
    }
}
