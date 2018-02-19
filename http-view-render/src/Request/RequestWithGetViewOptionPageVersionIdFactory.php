<?php

namespace Zrcms\HttpViewRender\Request;

use Psr\Container\ContainerInterface;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithGetViewOptionPageVersionIdFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RequestWithGetViewOptionPageVersionId
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new RequestWithGetViewOptionPageVersionId(
            $serviceContainer->get(IsAllowedRcmUserSitesAdmin::class),
            [],
            RequestWithGetViewOptionPageVersionId::DEFAULT_NOT_ALLOWED_MESSAGE,
            RequestWithGetViewOptionPageVersionId::DEFAULT_NOT_ALLOWED_STATUS,
            RequestWithGetViewOptionPageVersionId::DEFAULT_NOT_ALLOWED_HEADERS
        );
    }
}
