<?php

namespace Zrcms\Core\Container\Api\Repository;

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
     * @return array [ContainerCmsResource]
     */
    public function __invoke(
        string $siteCmsResourceId,
        array $containerCmsResourcePaths,
        array $options = []
    ): array;
}
