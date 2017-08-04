<?php

namespace Zrcms\Content\Exception;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertyMissingException extends \Exception
{
    /**
     * @param string $propertyName
     * @param array  $properties
     * @param string $class
     * @param array  $options
     *
     * @return PropertyMissingException
     */
    public static function build(
        string $propertyName,
        array $properties,
        string $class,
        array $options = []
    ) {

        $message = 'Required property (' . $propertyName . ') is missing '
            .'in: ' . $class;

        return new PropertyMissingException(
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
        parent::__construct($message, $code, $previous);
    }
}
