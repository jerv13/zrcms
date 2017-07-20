<?php

namespace Zrcms\Core\Container\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentVersion;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\Core\Container\Model\ContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContainerVersion extends FindContentVersion
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return ContainerVersion|ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
