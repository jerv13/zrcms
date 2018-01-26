<?php

namespace Zrcms\HttpApiSwagger\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiIsAllowedSwaggerFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiIsAllowedSwagger
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiIsAllowedSwagger(
            $serviceContainer->get(IsAllowedRcmUserSitesAdmin::class),
            [],
            'zrcms-swagger',
            401,
            IsDebug::invoke()
        );
    }
}
