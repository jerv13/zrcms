<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DetermineViewStrategyDefaultPublishedAnyFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return DetermineViewStrategyDefaultPublishedAny
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new DetermineViewStrategyDefaultPublishedAny(
            $serviceContainer->get(IsAllowedRcmUserSitesAdmin::class),
            []
        );
    }
}
