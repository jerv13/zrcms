<?php

namespace Zrcms\HttpViewRender\Acl;

use Psr\Container\ContainerInterface;
use Zrcms\CoreView\Api\ViewBuilder\DetermineViewStrategyPageVersionId;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpIsAllowedViewStrategyPageVersionIdFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpIsAllowedViewStrategyPageVersionId
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new HttpIsAllowedViewStrategyPageVersionId(
            $serviceContainer->get(DetermineViewStrategyPageVersionId::class),
            HttpIsAllowedViewStrategyPageVersionId::DEFAULT_NOT_ALLOWED_MESSAGE,
            HttpIsAllowedViewStrategyPageVersionId::DEFAULT_NOT_ALLOWED_STATUS,
            HttpIsAllowedViewStrategyPageVersionId::DEFAULT_NOT_ALLOWED_HEADERS
        );
    }
}
