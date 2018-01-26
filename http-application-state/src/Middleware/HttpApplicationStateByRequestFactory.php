<?php

namespace Zrcms\HttpApplicationState\Middleware;

use Psr\Container\ContainerInterface;
use Zrcms\CoreApplicationState\Api\GetApplicationState;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApplicationStateByRequestFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApplicationStateByRequest
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApplicationStateByRequest(
            $serviceContainer->get(GetApplicationState::class),
            IsDebug::invoke()
        );
    }
}
