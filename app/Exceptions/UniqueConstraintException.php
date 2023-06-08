<?php

namespace App\Exceptions;

/**
 * Class UniqueConstraintException
 *
 * @package App\Exceptions
 */
class UniqueConstraintException extends BaseAppException
{
    /**
     * @var string Префикс сообщения.
     */
    protected $messagePrefix  = 'Ограничение уникальности: ';

    /**
     * @var string Текст сообщения.
     */
    protected $message = '';

    protected $status = 418;
}
