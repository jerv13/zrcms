<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetContainerNamesByLayoutSiteContainersFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetContainerNamesByLayoutSiteContainers
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetContainerNamesByLayoutSiteContainers(
            $serviceContainer->get(GetTagNamesByLayout::class)
        );
    }
}
