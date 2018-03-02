<?php

namespace Zrcms\ServiceAlias\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetServiceAliasRegistryBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetServiceAliasRegistryBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registry = $config['zrcms-service-alias'];

        return new GetServiceAliasRegistryBasic(
            $registry
        );
    }
}
