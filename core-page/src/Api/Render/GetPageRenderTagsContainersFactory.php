<?php

namespace Zrcms\CorePage\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTags;
use Zrcms\CoreContainer\Api\Render\RenderContainer;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageRenderTagsContainersFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetPageRenderTagsContainers
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetPageRenderTagsContainers(
            $serviceContainer->get(GetContainerRenderTags::class),
            $serviceContainer->get(RenderContainer::class)
        );
    }
}
