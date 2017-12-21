<?php

namespace Zrcms\PageAccess\Middleware;

use Psr\Container\ContainerInterface;
use Zrcms\PageAccess\Api\Acl\IsAllowedPageAccess;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PageAccessByViewFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return PageAccessByView
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke($serviceContainer)
    {
        return new PageAccessByView(
            $serviceContainer->get(IsAllowedPageAccess::class)
        );
    }
}
