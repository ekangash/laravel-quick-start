<?php


namespace App\Support\Helpers;

use Illuminate\Support\Arr as LaravelArr;

/**
 * Class Arr
 * @package App\Support\Helpers
 */
class Arr extends LaravelArr
{

    /**
     * @param array $primary
     * @param array $secondary
     * @return array
     */
    public static function mergeNested(array $primary, array $secondary): array
    {
        $response = $primary;

        foreach ($secondary as $key => $value) {
            if (is_array($value) && is_array($response[$key])) {
                $response[$key] = self::mergeNested($response[$key], $value);
            } else {
                $response[$key] = $value;
            }
        }

        return $response;
    }

    /**
     * @param array $arr
     * @param array $keys
     * @param array $result
     *
     * @return array
     */
    static function onlyFromNested(array $arr, array $keys, array $result = []): array
    {
        foreach ($arr as $itemKey => $item) {
            if (in_array($itemKey, $keys)) {
                $result[] = $item;
            } else if (is_array($item)) {
                $result = static::onlyFromNested($item, $keys, $result);
            }
        }

        return $result;
    }

    /**
     * Фильтрует объект по ключам кроме указанных
     *
     * @param array $arr Исходный объект
     * @param array $keysToOmit Ключи, которые будут исключены из выборки
     *
     * @return array Массив, сформированный после фильтрации переданного объекта по парам ключ-значение.
     */
    public static function omit(array $arr, array $keysToOmit = []): array
    {
        $omitResult = [];

        foreach ($arr as $key => $value) {
            if (!in_array($key, $keysToOmit)) {
                $omitResult[$key] = $value;
            }
        }

        return $omitResult;
    }

}
