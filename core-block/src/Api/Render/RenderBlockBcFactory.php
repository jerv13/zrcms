<?php

namespace Zrcms\CoreBlock\Api\Render;

use Psr\Container\ContainerInterface;
use ZrcmsRcmCompatibility\RcmAdapter\GetRcmPluginController;
use ZrcmsRcmCompatibility\RcmAdapter\GetRcmViewRenderer;

/**
 * @deprecated BC only
 * @author     James Jervis - https://github.com/jerv13
 */
class RenderBlockBcFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RenderBlockBc
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new RenderBlockBc(
            $serviceContainer->get(GetRcmPluginController::class),
            $serviceContainer->get(GetRcmViewRenderer::class)
        );
    }
}
