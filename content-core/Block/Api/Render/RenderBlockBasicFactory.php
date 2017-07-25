<?php

namespace Zrcms\ContentCore\Block\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderBlockBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RenderBlockBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new RenderBlockBasic(
            $serviceContainer,
            $serviceContainer->get(FindBlockComponent::class),
            $serviceContainer->get(Cache::class)
        );
    }
}
