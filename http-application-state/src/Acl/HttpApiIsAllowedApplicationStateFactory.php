<?php

namespace Zrcms\HttpApplicationState\Acl;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiIsAllowedApplicationStateFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiIsAllowedApplicationState
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiIsAllowedApplicationState(
            $serviceContainer->get(IsAllowedRcmUserSitesAdmin::class),
            [],
            'application-state',
            HttpApiIsAllowedApplicationState::DEFAULT_NOT_ALLOWED_STATUS,
            IsDebug::invoke()
        );
    }
}
