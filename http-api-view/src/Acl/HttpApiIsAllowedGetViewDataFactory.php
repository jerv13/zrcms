<?php

namespace Zrcms\HttpApiView\Acl;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiIsAllowedGetViewDataFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiIsAllowedGetViewData
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiIsAllowedGetViewData(
            $serviceContainer->get(IsAllowedRcmUserSitesAdmin::class),
            [],
            'view-get-view-data',
            401,
            IsDebug::invoke()
        );
    }
}
