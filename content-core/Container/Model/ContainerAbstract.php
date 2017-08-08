<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Model\ContentAbstract;

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
        return $this->getProperty(
            PropertiesContainer::BLOCK_VERSIONS,
            []
        );
    }
}
