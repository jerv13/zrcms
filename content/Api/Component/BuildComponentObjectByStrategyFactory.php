<?php

namespace Zrcms\Content\Api\Component;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildComponentObjectByStrategyFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return BuildComponentObjectByStrategy
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $builderServiceConfig = $config['zrcms-component-object-builder'];

        return new BuildComponentObjectByStrategy(
            $serviceContainer,
            $builderServiceConfig
        );
    }
}
