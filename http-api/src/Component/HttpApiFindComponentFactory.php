<?php

namespace Zrcms\HttpApi\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Core\Api\Component\FindComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindComponentFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiFindComponent
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiFindComponent(
            $serviceContainer->get(FindComponent::class),
            $serviceContainer->get(ComponentToArray::class)
        );
    }
}
