<?php

namespace Zrcms\ContentCore\Block\Model;

use Zrcms\Content\Model\ComponentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockComponentAbstract extends ComponentAbstract
{
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
        parent::__construct(
            $properties,
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
        return $this->getProperty(
            PropertiesBlockComponent::DEFAULT_CONFIG,
            []
        );
    }

    /**
     * @return bool
     */
    public function isCacheable(): bool
    {
        return $this->getProperty(
            PropertiesBlockComponent::CACHEABLE,
            false
        );
    }
}
