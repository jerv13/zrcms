<?php

namespace Zrcms\PageAccess\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CoreView\Api\GetViewByRequest;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetApplicationStatePageAccessFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetApplicationStatePageAccess
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new GetApplicationStatePageAccess(
            $serviceContainer->get(GetViewByRequest::class),
            [],
            IsDebug::invoke()
        );
    }
}
