<?php

namespace Zrcms\HttpViewRender\Request;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithGetViewOptionPublishedOnlyFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RequestWithGetViewOptionPublishedOnly
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new RequestWithGetViewOptionPublishedOnly(
            $serviceContainer->get(IsAllowedRcmUserSitesAdmin::class),
            []
        );
    }
}
