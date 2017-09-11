<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\ContentAbstract;
use Zrcms\ContentCore\Container\Api\BuildBlockVersions;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerAbstract extends ContentAbstract
{
    /**
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        $blockVersions = Param::getArray(
            $properties,
            PropertiesContainer::BLOCK_VERSIONS,
            []
        );

        $properties[PropertiesContainer::BLOCK_VERSIONS] = BuildBlockVersions::prepare(
            $blockVersions
        );

        parent::__construct($properties);
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
