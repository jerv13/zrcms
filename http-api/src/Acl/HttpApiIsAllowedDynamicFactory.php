<?php

namespace Zrcms\HttpApi\Acl;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Debug\IsDebug;
use Zrcms\Http\Api\GetRouteOptions;
use Zrcms\HttpApi\GetDynamicApiValue;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiIsAllowedDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiIsAllowedDynamic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiIsAllowedDynamic(
            $serviceContainer,
            $serviceContainer->get(GetRouteOptions::class),
            $serviceContainer->get(GetDynamicApiValue::class),
            401,
            IsDebug::invoke()
        );
    }
}
