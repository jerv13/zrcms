<?php

namespace Zrcms\ContentCore\Container\Api\Repository;

use Zrcms\ContentCore\Container\Model\ContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContainerCmsResourcesBySitePaths
{
    /**
     * @param string $siteCmsResourceId
     * @param array  $containerCmsResourcePaths
     * @param array  $options
     *
     * @return ContainerCmsResource[]
     */
    public function __invoke(
        string $siteCmsResourceId,
        array $containerCmsResourcePaths,
        array $options = []
    ): array;
}
