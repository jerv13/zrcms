<?php

namespace Zrcms\HttpApi\CmsResource;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\CmsResource\CmsResourcesToArray;
use Zrcms\Debug\IsDebug;
use Zrcms\Http\Api\GetRouteOptions;
use Zrcms\HttpApi\GetDynamicApiValue;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiUpsertCmsResourceDynamicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiUpsertCmsResourceDynamic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiUpsertCmsResourceDynamic(
            $serviceContainer,
            $serviceContainer->get(GetRouteOptions::class),
            $serviceContainer->get(GetDynamicApiValue::class),
            $serviceContainer->get(GetUserIdByRequest::class),
            $serviceContainer->get(CmsResourcesToArray::class),
            IsDebug::invoke()
        );
    }
}
