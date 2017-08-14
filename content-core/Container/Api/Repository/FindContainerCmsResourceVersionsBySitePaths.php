<?php

namespace Zrcms\ContentCore\Container\Api\Repository;

use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\ContentCore\Container\Model\ContainerCmsResourceVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContainerCmsResourceVersionsBySitePaths
{
    /**
     * @param string $siteCmsResourceId
     * @param array  $containerCmsResourcePaths
     * @param array  $options
     *
     * @return ContainerCmsResourceVersion[]|CmsResourceVersion[]|array
     */
    public function __invoke(
        string $siteCmsResourceId,
        array $containerCmsResourcePaths,
        array $options = []
    );
}
