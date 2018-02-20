<?php

namespace Zrcms\CoreView\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderViewBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RenderViewBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new RenderViewBasic(
            $serviceContainer->get(GetServiceFromAlias::class),
            RenderViewLayout::class
        );
    }
}
