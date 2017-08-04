<?php

namespace Zrcms\ServiceAlias\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetServiceFromAliasBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetServiceFromAliasBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new GetServiceFromAliasBasic(
            $serviceContainer,
            $serviceContainer->get(GetServiceName::class)
        );
    }
}
