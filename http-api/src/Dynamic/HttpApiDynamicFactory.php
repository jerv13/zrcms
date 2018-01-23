<?php

namespace Zrcms\HttpApi\Dynamic;

use Psr\Container\ContainerInterface;
use Zrcms\Debug\IsDebug;
use Zrcms\Http\Api\GetRouteOptions;
use Zrcms\HttpApi\GetDynamicApiConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiDynamic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiDynamic(
            $serviceContainer->get(GetRouteOptions::class),
            $serviceContainer->get(GetDynamicApiConfig::class),
            405,
            IsDebug::invoke()
        );
    }
}
