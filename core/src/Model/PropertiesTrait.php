<?php

namespace Zrcms\Core\Model;

use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait PropertiesTrait
{
    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function findProperty(
        string $name,
        $default = null
    ) {
        return Property::get(
            $this->getProperties(),
            $name,
            $default
        );
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws \Exception
     */
    public function findPropertyRequired(
        string $name
    ) {
        $class = get_class($this);

        return Property::getRequired(
            $this->getProperties(),
            $name,
            "Required property ({$name}) is missing in: {$class}"
        );
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasProperty(
        string $name
    ): bool {
        return Property::has(
            $this->getProperties(),
            $name
        );
    }

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public function findDefaultIfEmptyProperty(
        string $name,
        $default = null
    ) {
        return Property::getDefaultIfEmpty(
            $this->getProperties(),
            $name,
            $default
        );
    }
}
