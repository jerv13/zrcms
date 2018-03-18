<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Container\ContainerInterface;
use Zrcms\CoreView\Api\GetLayoutCmsResource;
use Zrcms\CoreView\Api\GetLayoutName;
use Zrcms\CoreView\Api\GetPageCmsResource;
use Zrcms\CoreView\Api\GetSiteCmsResource;
use Zrcms\CoreView\Api\GetSiteContainerCmsResources;
use Zrcms\CoreView\Api\GetThemeName;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildViewDefaultFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return BuildViewDefault
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new BuildViewDefault(
            $serviceContainer->get(GetSiteCmsResource::class),
            $serviceContainer->get(GetThemeName::class),
            $serviceContainer->get(GetPageCmsResource::class),
            $serviceContainer->get(GetLayoutName::class),
            $serviceContainer->get(GetLayoutCmsResource::class),
            $serviceContainer->get(GetSiteContainerCmsResources::class)
        );
    }
}
