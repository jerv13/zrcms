<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\ContentVersionAbstract;
use Zrcms\ContentCore\Container\Api\BuildBlockVersions;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerVersionAbstract extends ContentVersionAbstract implements ContainerVersion
{
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
        $blockVersions = Param::getArray(
            $properties,
            PropertiesContainer::BLOCK_VERSIONS,
            []
        );

        $properties[PropertiesContainer::BLOCK_VERSIONS] = BuildBlockVersions::prepare(
            $blockVersions
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return array
     */
    public function getBlockVersions(): array
    {
        $blockVersions = $this->getProperty(
            PropertiesContainer::BLOCK_VERSIONS,
            []
        );

        return BuildBlockVersions::invoke(
            $this,
            $blockVersions
        );
    }
}
