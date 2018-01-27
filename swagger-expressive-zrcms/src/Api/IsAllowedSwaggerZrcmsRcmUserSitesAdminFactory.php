<?php

namespace Zrcms\SwaggerExpressiveZrcms\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedSwaggerZrcmsRcmUserSitesAdminFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return IsAllowedSwaggerZrcms
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new IsAllowedSwaggerZrcms(
            $serviceContainer->get(IsAllowedRcmUserSitesAdmin::class),
            []
        );
    }
}
