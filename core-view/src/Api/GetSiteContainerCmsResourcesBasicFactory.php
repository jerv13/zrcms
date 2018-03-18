<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesBy;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesBySitePaths;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTags;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetSiteContainerCmsResourcesBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetSiteContainerCmsResourcesBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetSiteContainerCmsResourcesBasic(
            $serviceContainer->get(FindContainerCmsResourcesBy::class),
            $serviceContainer->get(GetTagNamesByLayout::class),
            $serviceContainer->get(FindContainerCmsResourcesBySitePaths::class),
            $serviceContainer->get(GetContainerRenderTags::class)
        );
    }
}
