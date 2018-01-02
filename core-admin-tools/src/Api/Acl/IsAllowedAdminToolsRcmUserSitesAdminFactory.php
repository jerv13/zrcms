<?php

namespace Zrcms\CoreAdminTools\Api\Acl;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedRcmUser;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedAdminToolsRcmUserSitesAdminFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return IsAllowedAdminToolsRcmUserSitesAdmin
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new IsAllowedAdminToolsRcmUserSitesAdmin(
            $serviceContainer->get(IsAllowedRcmUser::class)
        );
    }
}
