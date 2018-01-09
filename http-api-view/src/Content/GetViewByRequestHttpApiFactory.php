<?php

namespace Zrcms\HttpApiView\Content;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\CoreView\Api\GetViewByRequest;
use Zrcms\CoreView\Api\ViewToArray;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewByRequestHttpApiFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetViewByRequestHttpApi
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetViewByRequestHttpApi(
            $serviceContainer->get(IsAllowedRcmUserSitesAdmin::class),
            $serviceContainer->get(GetViewByRequest::class),
            $serviceContainer->get(ViewToArray::class),
            [],
            404,
            401,
            IsDebug::invoke()
        );
    }
}
