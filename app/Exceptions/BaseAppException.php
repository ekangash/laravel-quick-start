<?php
declare(strict_types = 1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * BaseAppException Базовый класс для работы с пользовательскими ошибками приложения
 *
 * @package app\components\exceptions
 */
class BaseAppException extends HttpException {

	/**
	 * @var string Префикс сообщения.
	 */
	protected $messagePrefix  = '';

    /**
     * @var string Текст сообщения.
     */
    protected $message = '';


    /**
     * @var string Текст сообщения.
     */
    protected $status = 0;


    /**
	 * constructor.
	 *
	 * @param string $message Текст выбрасываемого исключения
	 *
	 * @return void
	 */
	public function __construct(string $message = '') {
        $exceptionMessage = empty($message) ? $this->message : $message;

		parent::__construct($this->status,$this->messagePrefix . $exceptionMessage);
	}
}
