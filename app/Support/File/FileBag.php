<?php

namespace App\Support\File;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * MediaFileBag is a container for uploaded files.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Bulat Shakirzyanov <mallluhuct@gmail.com>
 */
class FileBag extends ParameterBag
{
    private const FILE_KEYS = ['error', 'name', 'size', 'tmp_name', 'type'];

    /**
     * Выполняет конструктор класса.
     *
     * @param array $onlyAttributeNames  Только имена отслеживаемых атрибутов.
     *
     * @return void
     */
    public function __construct(array $onlyAttributeNames = [])
    {
        $files = Arr::only($_FILES, $onlyAttributeNames);
        parent::__construct($files);
        $this->add($files);
    }

    /**
     * Извлекает файл.
     *
     * @param string|null $name Имя файла.
     * @param mixed|null $default Значение по умолчанию.
     *
     * @return UploadedFile|array|null Извлеченный файл|Значение по умолчанию|Массив когда файл имеет вложенную структуру.
     */
    public function file(string $name = null, mixed $default = null): array|UploadedFile|null
    {
        return data_get($this->all(), $name, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function add(array $files = [])
    {
        foreach ($files as $key => $file) {
            $this->set($key, $file);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $key, $value)
    {
        if (!\is_array($value) && !$value instanceof UploadedFile) {
            throw new \InvalidArgumentException('An uploaded file must be an array or an instance of UploadedFile.');
        }

        parent::set($key, $this->convertFileInformation($value));
    }

    /**
     * Converts uploaded files to UploadedFile instances.
     *
     * @param array|UploadedFile $file A (multi-dimensional) array of uploaded file information
     *
     * @return UploadedFile[]|UploadedFile|null
     */
    protected function convertFileInformation(array|UploadedFile $file): array|UploadedFile|null
    {
        if ($file instanceof UploadedFile) {
            return $file;
        }

        $file = $this->fixPhpFilesArray($file);
        $keys = array_keys($file);
        sort($keys);

        if (self::FILE_KEYS == $keys) {
            $file = new UploadedFile($file['tmp_name'], $file['name'], $file['type'], $file['error'], false);
        } else {
            $file = array_map(function ($v) { return $v instanceof UploadedFile || \is_array($v) ? $this->convertFileInformation($v) : $v; }, $file);
            if (array_keys($keys) === $keys) {
                $file = array_filter($file);
            }
        }

        return $file;
    }

    /**
     * Fixes a malformed PHP $_FILES array.
     *
     * PHP has a bug that the format of the $_FILES array differs, depending on
     * whether the uploaded file fields had normal field names or array-like
     * field names ("normal" vs. "parent[child]").
     *
     * This method fixes the array to look like the "normal" $_FILES array.
     *
     * It's safe to pass an already converted array, in which case this method
     * just returns the original array unmodified.
     *
     * @param array $data
     *
     * @return array
     */
    protected function fixPhpFilesArray(array $data): array
    {
        // Remove extra key added by PHP 8.1.
        unset($data['full_path']);
        $keys = array_keys($data);
        sort($keys);

        if (self::FILE_KEYS != $keys || !isset($data['name']) || !\is_array($data['name'])) {
            return $data;
        }

        $files = [];

        foreach ($data['name'] as $key => $name) {
            $files[$key] = $this->fixPhpFilesArray([
                'error' => $data['error'][$key],
                'name' => $name,
                'type' => $data['type'][$key],
                'tmp_name' => $data['tmp_name'][$key],
                'size' => $data['size'][$key],
            ]);
        }

        return $files;
    }
}
