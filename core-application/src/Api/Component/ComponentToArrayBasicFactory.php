<?php

namespace Zrcms\CoreApplication\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\PropertiesToArray;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ComponentToArrayBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ComponentToArrayBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ComponentToArrayBasic(
            $serviceContainer->get(PropertiesToArray::class)
        );
    }
}
