<?php

namespace Zrcms\HttpApiBlockRender\Acl;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedBlockRenderFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return IsAllowedBlockRender
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new IsAllowedBlockRender(
            $serviceContainer->get(IsAllowedRcmUserSitesAdmin::class),
            []
        );
    }
}
