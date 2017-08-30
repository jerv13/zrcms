<?php

namespace Zrcms\ContentCore\Container\Api\Repository;

use Zrcms\Content\Exception\CmsResourceNotExistsException;
use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\ContentCore\Container\Model\ContainerCmsResourceVersion;

/**
 * Find published CmsResource by site and paths
 *
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
     * @throws CmsResourceNotExistsException
     * @throws ContentVersionNotExistsException
     */
    public function __invoke(
        string $siteCmsResourceId,
        array $containerCmsResourcePaths,
        array $options = []
    );
}
