<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\PropertyMissingException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContentAbstract implements Content
{
    use TrackableTrait;

    protected $id;
    protected $properties = [];

    /**
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        // Enforce immutability
        if ($this->hasTrackingData()) {
            return;
        }

        $this->properties = $properties;

        $this->setCreatedData(
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

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
    public function getProperty(string $name, $default = null)
    {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        return $default;
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws PropertyMissingException
     */
    public function getPropertyRequired(string $name)
    {
        if (!array_key_exists($name, $this->properties)) {
            $class = get_class($this);
            throw new PropertyMissingException(
                "Required property ({$name}) is missing in: {$class}"
            );
        }

        return $this->properties[$name];
    }
}
