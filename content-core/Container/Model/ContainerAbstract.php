<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\ContentAbstract;
use Zrcms\ContentCore\Container\Api\BuildBlockVersions;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerAbstract extends ContentAbstract implements Container
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
