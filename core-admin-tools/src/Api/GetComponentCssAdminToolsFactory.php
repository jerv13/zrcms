<?php

namespace Zrcms\CoreAdminTools\Api;

use Psr\Container\ContainerInterface;
use Reliv\CacheRat\Service\Cache;
use Zrcms\CoreAdminTools\Api\Acl\IsAllowedAdminToolsRcmUserSitesAdmin;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetComponentCssAdminToolsFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetComponentCssAdminTools
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetComponentCssAdminTools(
            $serviceContainer->get(IsAllowedAdminToolsRcmUserSitesAdmin::class),
            [],
            $serviceContainer->get(Cache::class),
            GetComponentCssAdminTools::DEFAULT_CACHE_KEY
        );
    }
}
