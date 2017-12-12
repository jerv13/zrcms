<?php

namespace Zrcms\Core\Model;

use Zrcms\Core\Exception\PropertyMissing;
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
    public function findProperty(
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
     * @throws \Exception
     * @throws PropertyMissing
     */
    public function findPropertyRequired(
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
    public function findDefaultIfEmptyProperty(
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
