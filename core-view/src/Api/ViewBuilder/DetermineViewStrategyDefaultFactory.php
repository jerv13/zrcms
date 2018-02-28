<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DetermineViewStrategyDefaultFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return DetermineViewStrategyDefault
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new DetermineViewStrategyDefault();
    }
}
