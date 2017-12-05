<?php

namespace Zrcms\Content\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Content\Api\GetTypeValue;

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
        return new BuildComponentObjectByStrategy(
            $serviceContainer,
            $serviceContainer->get(GetTypeValue::class)
        );
    }
}
