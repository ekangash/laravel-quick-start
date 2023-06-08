<?php

namespace App\Support\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BaseFormRequest
 *
 * @package App\Support\Requests
 */
abstract class BaseFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        $this->converter();

        return true;
    }

    /**
     * @return string[]
     */
    protected function converters():array {
        return [];
    }

    /**
     * @return void
     */
    protected function converter():void {
        foreach($this->converters() as $name => $toConvertType) {
            if($toConvertType === 'integer') {
                $this->convertStringToInteger($name);
            } else if ($toConvertType === 'boolean') {
                $this->convertStringToBoolean($name);
            } else if ($toConvertType === 'array') {
                $this->convertStringToArray($name);
            }
        }
    }

    /**
     * @param string $name
     *
     * @return void
     */
    protected function convertStringToArray(string $name): void
    {
        if (!$this->request->has($name)) {
            return;
        }

        $value = $this->request->get($name);

        if ($value && is_string($value)) {
            $array = json_decode($value, true);
            $this->request->set($name, $array);
        }
    }

    /**
     * @return void
     */
    protected function convertStringToInteger(string $name)
    {
        if (!$this->request->has($name)) {
            return;
        }

        $value = $this->request->get($name);
        $this->request->set($name, is_numeric($value) ? (int)$value : null);
    }

    /**
     * @return void
     */
    protected function convertStringToBoolean(string $name)
    {
        if (!$this->request->has($name)) {
            return;
        }

        $boolean = $this->request->get($name) === 'true';
        $this->request->set($name, $boolean);
    }
}
