<?php

namespace Zrcms\Core\Block\Model;

use Zrcms\Tracking\Model\TrackableTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockAbstract implements Block
{
    use TrackableTrait;
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $directory;

    /**
     * @var string
     */
    protected $renderer;

    /**
     * @var bool
     */
    protected $cacheable = false;

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var array
     */
    protected $defaultConfig = [];

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @param string $name
     * @param string $directory
     * @param string $renderer
     * @param bool   $cacheable
     * @param array  $fields
     * @param array  $defaultConfig
     * @param array  $properties
     */
    public function __construct(
        string $name,
        string $directory,
        string $renderer,
        boolean $cacheable = false,
        array $fields = [],
        array $defaultConfig = [],
        array $properties = [],
        string $createdByUserId,
        string $createdReason
    ) {
        $this->name = $name;
        $this->directory = $directory;
        $this->renderer = $renderer;
        $this->cacheable = $cacheable;
        $this->fields = $fields;
        $this->defaultConfig = $defaultConfig;
        $this->properties = $properties;

        $this->setCreatedData(
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * Unique name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Directory of template files
     *
     * @return string
     */
    public function getDirectory(): string
    {
        return $this->directory;
    }

    /**
     * Service name of render
     *
     * @return string
     */
    public function getRenderer(): string
    {
        return $this->renderer;
    }

    /**
     * Can the html be cached
     *
     * @return bool
     */
    public function isCacheable(): bool
    {
        return $this->cacheable;
    }

    /**
     * Admin fields
     *
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Default config values
     *
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return $this->defaultConfig;
    }

    /**
     * Extra properties
     *
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
}
