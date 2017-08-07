<?php

namespace Zrcms\ContentCore\Block\Api\Render;

use Psr\Container\ContainerInterface;

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
            $serviceContainer
        );
    }
}
