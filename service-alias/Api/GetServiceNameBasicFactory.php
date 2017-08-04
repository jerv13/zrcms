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
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registryConfig = $config['zrcms']['zrcms-service-alias'];

        return new GetServiceNameBasic(
            $registryConfig
        );
    }
}
