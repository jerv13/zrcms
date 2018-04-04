<?php

namespace Zrcms\CoreApplication\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\ComponentToArray;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ComponentsToArrayBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ComponentsToArrayBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ComponentsToArrayBasic(
            $serviceContainer->get(ComponentToArray::class)
        );
    }
}
