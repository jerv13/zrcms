<?php

namespace Zrcms\ContentCore\Block\Model;

use Zrcms\Content\Model\ComponentAbstract;
use Zrcms\ContentCore\Block\Fields\FieldsBlockComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockComponentAbstract extends ComponentAbstract
{
    /**
     * @param string      $category
     * @param string      $name
     * @param string      $configLocation
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     */
    public function __construct(
        string $category,
        string $name,
        string $configLocation,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        parent::__construct(
            $category,
            $name,
            $configLocation,
            $properties,
            $createdByUserId,
            $createdReason,
            $createdDate
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
            FieldsBlockComponent::DEFAULT_CONFIG,
            []
        );
    }

    /**
     * @return bool
     */
    public function isCacheable(): bool
    {
        return $this->getProperty(
            FieldsBlockComponent::CACHEABLE,
            false
        );
    }
}
