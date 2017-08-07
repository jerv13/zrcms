<?php

namespace Zrcms\Param\Exception;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ParamException extends \Exception
{
    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @param string $propertyName
     * @param array  $properties
     * @param string $class
     * @param array  $options
     *
     * @return ParamException
     */
    public static function build(
        string $propertyName,
        array $properties,
        string $class,
        array $options = []
    ) {

        $message = 'Required property (' . $propertyName . ') is missing '
            . 'in: ' . $class;

        return new ParamException(
            $message,
            $properties
        );
    }

    /**
     * @param string          $message
     * @param array           $properties
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = "", $properties = [], $code = 0, \Exception $previous = null)
    {
        $this->properties = $properties;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }
}
