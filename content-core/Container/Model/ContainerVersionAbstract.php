<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\ContentVersionAbstract;
use Zrcms\ContentCore\Container\Api\BuildBlockVersions;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerVersionAbstract extends ContentVersionAbstract implements ContainerVersion
{
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
