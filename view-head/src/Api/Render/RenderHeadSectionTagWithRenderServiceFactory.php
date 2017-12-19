<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionTagWithRenderServiceFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RenderHeadSectionTagWithRenderService
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new RenderHeadSectionTagWithRenderService(
            $serviceContainer,
            IsDebug::invoke()
        );
    }
}
