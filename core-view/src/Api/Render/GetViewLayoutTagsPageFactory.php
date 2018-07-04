<?php

namespace Zrcms\CoreView\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTags;
use Zrcms\CoreContainer\Api\Render\RenderContainer;
use Zrcms\CorePage\Api\Render\GetPageRenderTags;
use Zrcms\CoreView\Api\GetContainerNamesByLayoutPageContainers;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsPageFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetViewLayoutTagsPage
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetViewLayoutTagsPage(
            $serviceContainer->get(GetPageRenderTags::class),
            $serviceContainer->get(GetContainerNamesByLayoutPageContainers::class),
            $serviceContainer->get(GetContainerRenderTags::class),
            $serviceContainer->get(RenderContainer::class)
        );
    }
}
