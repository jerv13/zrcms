<?php

namespace Zrcms\CoreAdminTools\Api;

use Psr\Container\ContainerInterface;
use Reliv\CacheRat\Service\Cache;
use Zrcms\CoreAdminTools\Api\Acl\IsAllowedAdminToolsRcmUserSitesAdmin;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetComponentJsAdminToolsFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetComponentJsAdminTools
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetComponentJsAdminTools(
            $serviceContainer->get(IsAllowedAdminToolsRcmUserSitesAdmin::class),
            [],
            $serviceContainer->get(Cache::class),
            GetComponentJsAdminTools::DEFAULT_CACHE_KEY
        );
    }
}
