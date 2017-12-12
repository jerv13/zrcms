<?php

namespace Zrcms\CoreBlock\Model;

use Zrcms\Core\Model\ComponentAbstract;
use Zrcms\CoreBlock\Fields\FieldsBlockComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class BlockComponentAbstract extends ComponentAbstract
{
    /**
     * @param string      $type
     * @param string      $name
     * @param string      $configUri
     * @param string      $moduleDirectory
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     */
    public function __construct(
        string $type,
        string $name,
        string $configUri,
        string $moduleDirectory,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        parent::__construct(
            $type,
            $name,
            $configUri,
            $moduleDirectory,
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
        return $this->findProperty(
            FieldsBlockComponent::DEFAULT_CONFIG,
            []
        );
    }

    /**
     * @return bool
     */
    public function isCacheable(): bool
    {
        return $this->findProperty(
            FieldsBlockComponent::CACHEABLE,
            false
        );
    }
}
