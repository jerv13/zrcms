<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderData;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResourcesBySitePaths;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerVersion;
use Zrcms\ContentCore\View\Api\Repository\FindTagNamesByLayout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderDataContainersFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetViewRenderDataContainers
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new GetViewRenderDataContainers(
            $serviceContainer,
            $serviceContainer->get(FindTagNamesByLayout::class),
            $serviceContainer->get(FindContainerCmsResourcesBySitePaths::class),
            $serviceContainer->get(FindContainerVersion::class),
            $serviceContainer->get(GetContainerRenderData::class)
        );
    }
}
