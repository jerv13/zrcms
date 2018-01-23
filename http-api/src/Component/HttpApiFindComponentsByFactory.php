<?php

namespace Zrcms\HttpApi\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\ComponentsToArray;
use Zrcms\Core\Api\Component\FindComponentsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindComponentsByFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiFindComponentsBy
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiFindComponentsBy(
            $serviceContainer->get(FindComponentsBy::class),
            $serviceContainer->get(ComponentsToArray::class)
        );
    }
}
