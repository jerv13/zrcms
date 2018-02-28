<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DetermineViewStrategyPageVersionIdFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return DetermineViewStrategyPageVersionId
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new DetermineViewStrategyPageVersionId(
            $serviceContainer->get(IsAllowedRcmUserSitesAdmin::class),
            []
        );
    }
}
