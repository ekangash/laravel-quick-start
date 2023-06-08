<?php

namespace App\Domain\Model;

use App\Support\Helpers\Arr;
use App\Support\Helpers\Fls;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Domain\Models\AppModelWithMedia
 */
class AppModelWithMedia extends AppModel implements HasMedia
{
    use InteractsWithMedia;

    /**
     * Имена медиа атрибутов.
     */
    protected const MEDIA = [];

    /**
     * Формирует запись с учётом заполняемых полей и загрузкой медиа.

     * @param array $attributes Атрибуты записи.
     * @param Closure|null $middlewareFn Промежуточная функция обратного вызова.
     *
     * @return $this Экземпляр текущей записи.
     */
    public static function createWithFillableAndUploadMedia(array $attributes, Closure $middlewareFn = null): static
    {
        return DB::transaction(function() use ($attributes, $middlewareFn) {
            $mediaCollectionNames = static::MEDIA;
            $model = static::createWithFillable(Arr::omit($attributes, $mediaCollectionNames));

            if ($middlewareFn instanceof Closure) {
                $middlewareFn($model);
            }

            foreach ($mediaCollectionNames as $mediaCollectionName) {
                if (array_key_exists($mediaCollectionName, $attributes)) {
                    $model->setMediaAttribute($mediaCollectionName, Arr::get($attributes, $mediaCollectionName));
                }
            }

            $model->update();

            return $model;
        });
    }

    /**
     * Формирует новую тему.

     * @param int $id Значение первичного ключа.
     * @param array $attributes Атрибуты записи.
     * @param Closure|null $middlewareFn Промежуточная функция обратного вызова.
     *
     * @return $this Экземпляр текущей записи.
     *
     * @throws ModelNotFoundException
     */
    public static function updateWithFillableAndUploadMedia(int $id, array $attributes, Closure $middlewareFn = null): static
    {
        return DB::transaction(function() use ($id, $attributes, $middlewareFn) {
            $model = static::findOrFail($id);
            $mediaCollectionNames = static::MEDIA;
            $model->fillWithFillable(Arr::omit($attributes, $mediaCollectionNames));

            if ($middlewareFn instanceof Closure) {
                $middlewareFn($model);
            }

            foreach ($mediaCollectionNames as $mediaCollectionName) {
                if (array_key_exists($mediaCollectionName, $attributes)) {
                    $model->setMediaAttribute($mediaCollectionName, Arr::get($attributes, $mediaCollectionName));
                }
            }

            $model->update();

            return $model;
        });
    }

    /**
     * Формирует новую тему.
     *
     * @param int $id Значение первичного ключа.
     * @param Closure|null $middlewareFn Промежуточная функция обратного вызова.
     *
     * @return bool|null
     */
    public static function deleteAndClearMedia(int $id, Closure $middlewareFn = null) : ?bool
    {
        return DB::transaction(function() use ($id, $middlewareFn) {
            $model = static::findOrFail($id);

            if ($middlewareFn instanceof Closure) {
                $middlewareFn($model);
            }

            $model->clearMediaCollections(static::MEDIA);

            return $model->delete();
        });
    }

    /**
     * Очищает медиа коллекции записи.
     *
     * @param array $mediaCollectionNames Имена медиа коллекций.
     *
     * @return void
     */
    public function clearMediaCollections(array $mediaCollectionNames = [])
    {
        foreach ($mediaCollectionNames as $mediaCollectionName) {
            $this->clearMediaCollection($mediaCollectionName);
        }
    }

    /**
     * Устанавливает значение медиа-атрибуту.
     *
     * @param string $mediaCollectionName Имя коллекции.
     * @param mixed $uploadedMedia Загружаемое медиа.
     *
     * @return void
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function setMediaAttribute(string $mediaCollectionName, mixed $uploadedMedia)
    {
        $attribute = $uploadedMedia;

        if (Fls::hasUploadedFile($uploadedMedia)) {
            $attribute = is_array($uploadedMedia)
                ? $this->uploadNestedMedia($mediaCollectionName, $uploadedMedia)
                : $this->uploadMedia($mediaCollectionName, $uploadedMedia);
            $usedAttributeUrls = is_array($attribute) ? Arr::onlyFromNested($attribute, ['src']) : [$attribute];

            $this->clearUnusedMedia($this->getMedia($mediaCollectionName), $usedAttributeUrls);
        }

        $this->setAttribute($mediaCollectionName, $attribute);
    }

    /**
     * Загружает медиа-файл.
     *
     * @param string $mediaCollectionName Имя коллекции.
     * @param string|UploadedFile|null $uploadedFile Значение атрибута файла.
     *
     * @return string|null Ссылка загружаемого медиа.
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function uploadMedia(string $mediaCollectionName, mixed $uploadedFile): ?string
    {
        if ($uploadedFile instanceof UploadedFile && $uploadedFile->getSize() > 0) {
            $media = $this->addMedia($uploadedFile)->toMediaCollection($mediaCollectionName);

            return $media instanceof Media ? $media->getUrl() : null;
        }

        return null;
    }

    /**
     * Загружает медиа-файлы из вложенной структуры данных, заменяя объект UploadedFile на url ссылку.
     *
     * @param string $mediaCollectionName Имя коллекции.
     * @param array $nestedUploadedFiles Вложенное значение медиа атрибута.
     *
     * @return array Вложенная измененная структура.
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function uploadNestedMedia(string $mediaCollectionName, array $nestedUploadedFiles): array
    {
        $modificationFiles = $nestedUploadedFiles;

        foreach ($nestedUploadedFiles as $key => $nestedFile) {
            if ($nestedFile instanceof UploadedFile) {
                if ($nestedFile->getSize() > 0) {
                    $mediaModel = $this->addMedia($nestedFile)->toMediaCollection($mediaCollectionName);
                    $modificationFiles[$key] = $mediaModel->getUrl();
                }
            } else if (is_array($nestedFile)) {
                $modificationFiles[$key] = $this->uploadNestedMedia($mediaCollectionName, $nestedFile);
            }
        }

        return $modificationFiles;
    }

    /**
     * Очищает неиспользуемые медиа.
     *
     * @param MediaCollection $mediaCollection Медиа коллекция.
     * @param array $usedUrls Используемые медиа ссылки.
     *
     * @return void
     */
    public function clearUnusedMedia(MediaCollection $mediaCollection, array $usedUrls)
    {
        $mediaCollection->map(function(Media $mediaItem) use ($usedUrls) {
            if (!in_array($mediaItem->getUrl(), $usedUrls, true)) {
                $mediaItem->delete();
            }
        });
    }

    /**
     * Удаляет медиа коллекции текущей модели.
     *
     * @param string $mediaCollectionName Имя коллекции.
     *
     * @return string Абсолютная ссылка до медиа-ресурса.
     */
    public function getFirstMediaFullUrl(string $mediaCollectionName): string
    {
        return (string)$this->getMedia($mediaCollectionName)->reduce(function($media, Media $mediaItem) {
            return $mediaItem->getFullUrl();
        }, '');
    }

    /**
     * Удаляет медиа коллекции текущей модели.
     *
     * @param string $mediaCollectionName Имя коллекции.
     *
     * @return string Относительная ссылка до медиа-ресурса.
     */
    public function getFirstMediaUrl(string $mediaCollectionName): string
    {
        return (string)$this->getMedia($mediaCollectionName)->reduce(function($media, Media $mediaItem) {
            return $mediaItem->getUrl();
        }, '');
    }
}
