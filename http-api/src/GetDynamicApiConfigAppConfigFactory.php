<?php

namespace Zrcms\HttpApi;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetDynamicApiConfigAppConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetDynamicApiConfigAppConfig
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        return new GetDynamicApiConfigAppConfig(
            $config['zrcms-http-api-dynamic']
        );
    }
}
