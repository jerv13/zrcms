<?php

namespace Zrcms\Core\Block\Model;

use Zrcms\Content\Model\ComponentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockComponentAbstract extends ComponentAbstract  implements BlockComponent
{
    /**
     * @var array
     */
    protected $defaultConfig = [];

    /**
     * @var bool
     */
    protected $cacheable = false;

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
        $this->defaultConfig = Param::get(
            $properties,
            PropertiesBlockComponent::DEFAULT_CONFIG,
            []
        );

        $this->cacheable = Param::get(
            $properties,
            PropertiesBlockComponent::CACHEABLE,
            false
        );

        parent::__construct(
            $properties = [],
            $createdByUserId,
            $createdReason
        );
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
