<?php

namespace Zrcms\CoreBlock\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockDataBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetBlockDataBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new GetBlockDataBasic(
            $serviceContainer->get(GetServiceFromAlias::class),
            $serviceContainer->get(FindComponent::class)
        );
    }
}
