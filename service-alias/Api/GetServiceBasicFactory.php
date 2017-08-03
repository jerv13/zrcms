<?php

namespace Zrcms\ServiceAlias\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetServiceBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetServiceBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new GetServiceBasic(
            $serviceContainer,
            $serviceContainer->get(GetServiceName::class)
        );
    }
}
