<?php

namespace App\Exceptions\Http;

use App\Exceptions\BaseAppException;

class IAmTeapotException extends BaseAppException
{
    /**
     * @var string Префикс сообщения.
     */
    protected $messagePrefix  = 'Ограничение: ';

    /**
     * @var string Текст сообщения.
     */
    protected $message = '';

    protected $status = 418;
}
