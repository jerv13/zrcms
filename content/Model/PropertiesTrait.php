<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\PropertyMissing;
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
    public function getProperty(
        string $name,
        $default = null
    ) {
        return Param::get(
            $this->getProperties(),
            $name,
            $default
        );
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws PropertyMissing
     */
    public function getPropertyRequired(
        string $name
    ) {
        $class = get_class($this);

        return Param::getRequired(
            $this->getProperties(),
            $name,
            new PropertyMissing(
                "Required property ({$name}) is missing in: {$class}"
            )
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
        return Param::has(
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
    public function getDefaultIfEmptyProperty(
        string $name,
        $default = null
    ) {
        return Param::getDefaultIfEmpty(
            $this->getProperties(),
            $name,
            $default
        );
    }
}
