<?php

namespace Zrcms\ServiceAlias\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetServiceNameBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetServiceNameBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetServiceNameBasic(
            $serviceContainer->get(GetServiceAliasRegistry::class)
        );
    }
}
