<?php

namespace Zrcms\HttpApi\ZrcmsConfig;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiIsAllowedZrcmsConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiIsAllowedZrcmsConfig
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiIsAllowedZrcmsConfig(
            $serviceContainer->get(IsAllowedRcmUserSitesAdmin::class),
            [],
            'repository-find-component',
            401,
            IsDebug::invoke()
        );
    }
}
