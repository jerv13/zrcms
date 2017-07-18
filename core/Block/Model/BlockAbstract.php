<?php

namespace Zrcms\Core\Block\Model;

use Zrcms\Content\Model\ContentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockAbstract extends ContentAbstract implements Block
{
    /**
     * @var string
     */
    protected $directory;

    /**
     * @var array
     */
    protected $defaultConfig = [];

    /**
     * @var bool
     */
    protected $cacheable = false;

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties = [],
        string $createdByUserId,
        string $createdReason
    ) {
        $this->id = Param::getRequired(
            $properties,
            BlockProperties::NAME
        );

        $this->directory = Param::getRequired(
            $properties,
            BlockProperties::DIRECTORY
        );

        $this->defaultConfig = Param::get(
            $properties,
            BlockProperties::CONFIG,
            []
        );

        $this->cacheable = Param::get(
            $properties,
            BlockProperties::CACHEABLE,
            false
        );

        parent::__construct(
            $properties = [],
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * Unique name ID
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->id;
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
     * Default config values
     *
     * @return array
     */
    public function getDefaultConfig(): array
    {
        return $this->defaultConfig;
    }

    /**
     * @return bool
     */
    public function isCacheable(): bool
    {
        return $this->cacheable;
    }
}
