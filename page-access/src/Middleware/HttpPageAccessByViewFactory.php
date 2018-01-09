<?php

namespace Zrcms\PageAccess\Middleware;

use Psr\Container\ContainerInterface;
use Zrcms\PageAccess\Api\Acl\IsAllowedPageAccess;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpPageAccessByViewFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpPageAccessByView
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke($serviceContainer)
    {
        return new HttpPageAccessByView(
            $serviceContainer->get(IsAllowedPageAccess::class)
        );
    }
}
