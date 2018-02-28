<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildRequestedViewByConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return BuildRequestedViewByConfig
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        $appConfig = $serviceContainer->get('config');

        $config = $appConfig['zrcms-view-build-view-strategy'];

        return new BuildRequestedViewByConfig(
            $config,
            $serviceContainer
        );
    }
}
