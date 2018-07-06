<?php

namespace Zrcms\CoreBlock\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderBlockBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RenderBlockBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new RenderBlockBasic(
            $serviceContainer->get(GetServiceFromAlias::class),
            $serviceContainer->get(FindComponent::class),
            $serviceContainer->get(RenderBlockMissing::class),
            RenderBlockMustache::class
        );
    }
}
