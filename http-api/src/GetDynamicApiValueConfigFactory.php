<?php

namespace Zrcms\HttpApi;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetDynamicApiValueConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetDynamicApiValueConfig
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        return new GetDynamicApiValueConfig(
            $config['zrcms-http-api']
        );
    }
}
