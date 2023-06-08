<?php

namespace App\Exceptions\Http;

use App\Exceptions\BaseAppException;

class ForbiddenException extends BaseAppException
{
    /**
     * @var string Текст сообщения.
     */
    protected $message = '';

    protected $status = 403;
}
