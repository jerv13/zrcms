<?php

namespace Zrcms\CoreApplicationState\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Debug\IsDebug;

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
        $appConfig = $serviceContainer->get('config');
        return new GetApplicationStateByConfig(
            $appConfig['zrcms-application-state'],
            $serviceContainer,
            IsDebug::invoke()
        );
    }
}
