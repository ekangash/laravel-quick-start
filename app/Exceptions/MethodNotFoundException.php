<?php


namespace App\Exceptions;

/**
 * Class MethodNotFoundException
 *
 * @package App\Exceptions
 */
class MethodNotFoundException  extends BaseAppException
{
    /**
     * @var string|object
     */
    private $classname;

    /**
     * @var string
     */
    private $methodName;

    /**
     * @var array
     */
    private $arguments;

    /**
     * @param string $message
     * @param string|object $classname
     * @param string $methodName
     * @param null|array $arguments
     */
    public function __construct($message, $classname, $methodName, $arguments = null)
    {
        parent::__construct($message);

        $this->classname  = $classname;
        $this->methodName = $methodName;
        $this->arguments = $arguments;
    }

    /**
     * @return object|string
     */
    public function getClassname()
    {
        return $this->classname;
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @return array|null
     */
    public function getArguments()
    {
        return $this->arguments;
    }
}

