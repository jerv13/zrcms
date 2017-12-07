<?php

namespace Zrcms\Content\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Content\Api\GetTypeValue;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildComponentObjectByTypeFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return BuildComponentObjectByType
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new BuildComponentObjectByType(
            $serviceContainer,
            $serviceContainer->get(GetTypeValue::class)
        );
    }
}
