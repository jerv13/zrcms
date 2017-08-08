<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\ContentVersionAbstract;

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
        return $this->getProperty(
            PropertiesContainer::BLOCK_VERSIONS,
            []
        );
    }
}
