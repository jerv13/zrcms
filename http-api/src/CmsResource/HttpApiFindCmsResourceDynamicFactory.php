<?php

namespace Zrcms\HttpApi\CmsResource;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Debug\IsDebug;
use Zrcms\Http\Api\GetRouteOptions;
use Zrcms\HttpApi\GetDynamicApiValue;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindCmsResourceDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiFindCmsResourceDynamic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiFindCmsResourceDynamic(
            $serviceContainer,
            $serviceContainer->get(GetRouteOptions::class),
            $serviceContainer->get(GetDynamicApiValue::class),
            $serviceContainer->get(CmsResourceToArray::class),
            404,
            IsDebug::invoke()
        );
    }
}
