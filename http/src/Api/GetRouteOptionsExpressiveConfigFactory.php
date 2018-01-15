<?php

namespace Zrcms\Http\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetRouteOptionsExpressiveConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetRouteOptionsExpressiveConfig
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        $appConfig = $serviceContainer->get('config');

        return new GetRouteOptionsExpressiveConfig(
            $appConfig['routes'],
            $serviceContainer->get(Cache::class),
            GetRouteOptionsExpressiveConfig::CACHE_KEY
        );
    }
}
