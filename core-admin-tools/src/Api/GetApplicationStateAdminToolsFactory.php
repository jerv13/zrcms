<?php

namespace Zrcms\CoreAdminTools\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CoreAdminTools\Api\Acl\IsAllowedAdminTools;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetApplicationStateAdminToolsFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetApplicationStateAdminTools
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        $appConfig = $serviceContainer->get('config');

        return new GetApplicationStateAdminTools(
            $serviceContainer->get(IsAllowedAdminTools::class),
            $appConfig['zrcms-admin-tools-menu']
        );
    }
}
