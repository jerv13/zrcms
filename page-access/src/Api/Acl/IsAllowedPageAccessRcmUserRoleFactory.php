<?php

namespace Zrcms\PageAccess\Api\Acl;

use Psr\Container\ContainerInterface;
use RcmUser\Api\Acl\HasRoleBasedAccess;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedPageAccessRcmUserRoleFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return IsAllowedPageAccessRcmUserRole
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new IsAllowedPageAccessRcmUserRole(
            $serviceContainer->get(HasRoleBasedAccess::class)
        );
    }
}
