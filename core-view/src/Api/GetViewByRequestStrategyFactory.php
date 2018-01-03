<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewByRequestStrategyFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetViewByRequestStrategy
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        $appConfig = $serviceContainer->get('config');
        return new GetViewByRequestStrategy(
            $appConfig['zrcms-view-by-request-strategy'],
            $serviceContainer
        );
    }
}
