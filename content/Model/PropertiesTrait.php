<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait PropertiesTrait
{
    /**
     * @var array
     */
    protected $properties = [];

    protected function propertyFromMethod(
        $name,
        $default = null
    ) {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        $method = 'is' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        return Param::get(
            $this->properties,
            $name,
            $default
        );
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        $properties = [];

        foreach ($this->properties as $name => $value) {
            $properties[$name] = $this->propertyFromMethod(
                $name
            );
        }

        return $properties;
    }

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function getProperty(
        string $name,
        $default = null
    ) {
        return $this->propertyFromMethod(
            $name
        );
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasProperty(
        string $name
    ): bool
    {
        $properties = $this->getProperties();

        return Param::has(
            $properties,
            $name
        );
    }
}
