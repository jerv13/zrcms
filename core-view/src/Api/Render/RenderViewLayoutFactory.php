<?php

namespace Zrcms\CoreView\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\CoreTheme\Api\Render\RenderLayout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderViewLayoutFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RenderViewLayout
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new RenderViewLayout(
            $serviceContainer->get(RenderLayout::class)
        );
    }
}
