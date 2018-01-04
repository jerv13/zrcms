<?php

namespace Zrcms\HttpAssetsApplicationState\Middleware;

use Psr\Container\ContainerInterface;
use Zrcms\CoreApplicationState\Api\GetApplicationState;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ApplicationStateFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ApplicationState
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ApplicationState(
            $serviceContainer->get(GetApplicationState::class),
            IsDebug::invoke()
        );
    }
}
