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
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new RenderBlockBc(
            $serviceContainer->get(GetRcmPluginController::class),
            $serviceContainer->get(GetRcmViewRenderer::class)
        );
    }
}
