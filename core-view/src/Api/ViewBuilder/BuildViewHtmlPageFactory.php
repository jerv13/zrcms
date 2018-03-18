<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Container\ContainerInterface;
use Zrcms\CoreView\Api\GetLayoutCmsResource;
use Zrcms\CoreView\Api\GetLayoutName;
use Zrcms\CoreView\Api\GetSiteCmsResource;
use Zrcms\CoreView\Api\GetSiteContainerCmsResources;
use Zrcms\CoreView\Api\GetThemeName;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildViewHtmlPageFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return BuildViewHtmlPage
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new BuildViewHtmlPage(
            $serviceContainer->get(GetSiteCmsResource::class),
            $serviceContainer->get(GetThemeName::class),
            $serviceContainer->get(GetLayoutName::class),
            $serviceContainer->get(GetLayoutCmsResource::class),
            $serviceContainer->get(GetSiteContainerCmsResources::class),
            '',
            '',
            ''
        );
    }
}
