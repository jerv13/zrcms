<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderViewBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RenderViewBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new RenderViewBasic(
            $serviceContainer
        );
    }
}
