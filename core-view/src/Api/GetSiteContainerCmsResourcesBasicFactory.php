<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTags;
use Zrcms\CoreSiteContainer\Api\CmsResource\FindSiteContainerCmsResourcesBy;
use Zrcms\CoreSiteContainer\Api\CmsResource\FindSiteContainerCmsResourcesBySiteNames;

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
            $serviceContainer->get(FindSiteContainerCmsResourcesBy::class),
            $serviceContainer->get(GetTagNamesByLayout::class),
            $serviceContainer->get(FindSiteContainerCmsResourcesBySiteNames::class),
            $serviceContainer->get(GetContainerRenderTags::class)
        );
    }
}
