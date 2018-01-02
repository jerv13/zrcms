<?php

namespace Zrcms\CoreApplicationState\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetApplicationStateByConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetApplicationStateByConfig
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetApplicationStateByConfig(
            $serviceContainer->get('config'),
            $serviceContainer
        );
    }
}
