<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetApplicationStateViewFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetApplicationStateView
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetApplicationStateView(
            $serviceContainer->get(GetViewByRequest::class)
        );
    }
}
