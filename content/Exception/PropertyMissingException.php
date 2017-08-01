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
        return new PropertyMissingException(
            'Required property (' . $propertyName . ') is missing '
            .'in: ' . $class
            //. ' with properties: ' . json_encode($properties, JSON_PRETTY_PRINT)
        );
    }
}
