<?php

namespace Zrcms\CoreApplication\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\GetTypeValue;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildComponentObjectByTypeStrategyFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return BuildComponentObjectByTypeStrategy
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new BuildComponentObjectByTypeStrategy(
            $serviceContainer,
            $serviceContainer->get(GetTypeValue::class)
        );
    }
}
