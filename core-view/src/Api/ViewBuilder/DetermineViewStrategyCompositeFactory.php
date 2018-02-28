<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DetermineViewStrategyCompositeFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return DetermineViewStrategyComposite
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        $appConfig = $serviceContainer->get('config');

        $config = $appConfig['zrcms-view-determine-strategy'];

        return new DetermineViewStrategyComposite(
            $config,
            $serviceContainer
        );
    }
}
