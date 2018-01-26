<?php

namespace Zrcms\HttpApi\Acl;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiIsAllowedFindComponentFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiIsAllowedFindComponent
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiIsAllowedFindComponent(
            $serviceContainer->get(IsAllowedRcmUserSitesAdmin::class),
            [],
            'zrcms-config-list',
            401,
            IsDebug::invoke()
        );
    }
}
