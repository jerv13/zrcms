<?php

namespace Zrcms\ServiceAlias\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetServiceAliasesByNamespaceBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetServiceAliasesByNamespaceBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetServiceAliasesByNamespaceBasic(
            $serviceContainer->get(GetServiceAliasRegistry::class)
        );
    }
}
