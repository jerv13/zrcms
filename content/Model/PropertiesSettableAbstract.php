<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class PropertiesSettableAbstract implements Properties
{
    use PropertiesTrait;

    /**
     * @param array $properties
     */
    public function __construct(
        array $properties = []
    ) {
        $this->properties = array_merge(
            $this->properties,
            $properties
        );
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return void
     */
    public function setProperty(string $name, $value)
    {
        $this->properties[$name] = $value;
    }
}
