<?php

namespace Zrcms\ContentVersionControl\Model;

use Zrcms\ContentVersionControl\Exception\PropertyMissingException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait ContentTrait
{
    /**
     * @var string
     */
    protected $uri;

    /**
     * @var string
     */
    protected $sourceUri;

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * The URI of the content this was created from
     * For tracking URI changes and copied content
     *
     * @return string
     */
    public function getSourceUri(): string
    {
        return $this->sourceUri;
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
