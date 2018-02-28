<?php

namespace Zrcms\HttpViewRender\Acl;

use Psr\Container\ContainerInterface;
use Zrcms\CoreView\Api\ViewBuilder\DetermineViewStrategyDefaultPublishedAny;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpIsAllowedViewStrategyPublishedAnyFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpIsAllowedViewStrategyPublishedAny
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new HttpIsAllowedViewStrategyPublishedAny(
            $serviceContainer->get(DetermineViewStrategyDefaultPublishedAny::class),
            HttpIsAllowedViewStrategyPublishedAny::DEFAULT_NOT_ALLOWED_MESSAGE,
            HttpIsAllowedViewStrategyPublishedAny::DEFAULT_NOT_ALLOWED_STATUS,
            HttpIsAllowedViewStrategyPublishedAny::DEFAULT_NOT_ALLOWED_HEADERS
        );
    }
}
